<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportMysqlDump extends Command
{
    protected $signature = 'db:import-mysql-dump {file? : Path to MySQL dump file}';
    protected $description = 'Import data from MySQL dump into current database with column mapping';

    public function handle()
    {
        $file = $this->argument('file') ?? base_path('../database.sql');
        
        if (!file_exists($file)) {
            $this->error("File not found: $file");
            return 1;
        }

        $content = file_get_contents($file);

        $tables = [
            'users', 'destinations', 'gallery_items', 'packages',
            'page_images', 'personal_access_tokens', 'reviews', 'settings'
        ];

        foreach ($tables as $table) {
            $this->importTable($content, $table);
        }

        $this->info('Import complete.');
        return 0;
    }

    private function importTable(string $content, string $table): void
    {
        // Find INSERT INTO `table` VALUES position
        $pattern = '/INSERT INTO `' . $table . '` VALUES\s*/';
        if (!preg_match($pattern, $content, $m, PREG_OFFSET_CAPTURE)) {
            $this->warn("  $table: no INSERT found");
            return;
        }

        $insertPos = $m[0][1] + strlen($m[0][0]);

        // Extract full VALUES block by counting parentheses
        $valuesBlock = $this->extractValuesBlock($content, $insertPos);
        if ($valuesBlock === null) {
            $this->warn("  $table: could not extract VALUES block");
            return;
        }

        // Parse MySQL columns from CREATE TABLE
        $mysqlCols = $this->getMysqlColumns($content, $table);

        // Get SQLite columns
        $sqliteCols = [];
        $pragmas = DB::select("PRAGMA table_info('$table')");
        foreach ($pragmas as $p) {
            $sqliteCols[] = $p->name;
        }

        $this->info("$table: MySQL " . count($mysqlCols) . " cols → SQLite " . count($sqliteCols) . " cols");

        // Check if already has data
        $count = DB::table($table)->count();
        if ($count > 0) {
            $this->warn("  Already has $count rows, skipping");
            return;
        }

        // Parse rows
        $rows = $this->parseValuesBlock($valuesBlock);
        $this->info("  Parsed " . count($rows) . " rows");

        $total = 0;
        foreach ($rows as $row) {
            $data = [];
            foreach ($sqliteCols as $col) {
                $idx = array_search($col, $mysqlCols);
                if ($idx !== false && isset($row[$idx])) {
                    $data[$col] = $row[$idx];
                }
            }

            if (!empty($data)) {
                try {
                    DB::table($table)->insert($data);
                    $total++;
                } catch (\Exception $e) {
                    $this->error("  ERROR: " . $e->getMessage());
                    $this->error("  Keys: " . implode(', ', array_keys($data)));
                    throw $e;
                }
            }
        }

        $this->info("  Inserted: $total rows");
    }

    private function extractValuesBlock(string $content, int $start): ?string
    {
        // The MySQL dump format is: INSERT INTO `table` VALUES (row1),(row2),...,(rowN);
        // We need to extract everything from the first '(' after VALUES to the terminating ';'
        // BUT that terminating ';' must be outside any string.

        $len = strlen($content);

        // Skip whitespace to first '('
        while ($start < $len && ($content[$start] === ' ' || $content[$start] === "\t" ||
               $content[$start] === "\n" || $content[$start] === "\r")) {
            $start++;
        }

        if ($start >= $len || $content[$start] !== '(') {
            return null;
        }

        // Now scan forward to find the terminating ';' that's outside any string.
        // We track string state and paren depth to know when we're truly outside.
        $i = $start;
        $inStr = false;
        $depth = 0;

        while ($i < $len) {
            $ch = $content[$i];

            if ($inStr) {
                if ($ch === '\\') {
                    $i += 2; // skip escaped char
                    continue;
                }
                if ($ch === "'") {
                    if ($i + 1 < $len && $content[$i + 1] === "'") {
                        // MySQL doubled single quote inside string
                        $i += 2;
                        continue;
                    }
                    $inStr = false;
                }
                $i++;
                continue;
            }

            if ($ch === "'") {
                $inStr = true;
                $i++;
                continue;
            }

            if ($ch === '(') {
                $depth++;
            } elseif ($ch === ')') {
                $depth--;
            } elseif ($ch === ';' && $depth === 0) {
                // Found the terminating semicolon!
                return substr($content, $start, $i - $start);
            }

            $i++;
        }

        // If no terminating ';' found, return what we have
        return substr($content, $start, $i - $start);
    }

    private function getMysqlColumns(string $content, string $table): array
    {
        if (!preg_match('/CREATE TABLE `' . $table . '` \((.*?)\) ENGINE=/s', $content, $m)) {
            return [];
        }
        preg_match_all('/`(\w+)`/', $m[1], $cols);
        return $cols[1];
    }

    private function parseValuesBlock(string $block): array
    {
        $rows = [];
        $len = strlen($block);
        $i = 0;

        while ($i < $len) {
            // Skip whitespace and commas between rows
            while ($i < $len && ($block[$i] === ' ' || $block[$i] === "\t" ||
                   $block[$i] === "\n" || $block[$i] === "\r" || $block[$i] === ',')) {
                $i++;
            }
            if ($i >= $len || $block[$i] !== '(') {
                break;
            }

            $row = $this->parseOneRow($block, $i);
            $rows[] = $row[0];
            $i = $row[1];
        }

        return $rows;
    }

    private function parseOneRow(string $s, int $start): array
    {
        $vals = [];
        $i = $start + 1;
        $len = strlen($s);

        while ($i < $len) {
            while ($i < $len && ($s[$i] === ' ' || $s[$i] === "\t" ||
                   $s[$i] === "\n" || $s[$i] === "\r")) {
                $i++;
            }

            if ($i >= $len) break;
            if ($s[$i] === ')') return [$vals, $i + 1];

            $result = $this->parseOneValue($s, $i);
            $vals[] = $result[0];
            $i = $result[1];

            while ($i < $len && ($s[$i] === ' ' || $s[$i] === "\t" ||
                   $s[$i] === "\n" || $s[$i] === "\r")) {
                $i++;
            }

            if ($i < $len && $s[$i] === ',') {
                $i++;
            } elseif ($i < $len && $s[$i] === ')') {
                return [$vals, $i + 1];
            }
        }

        return [$vals, $i];
    }

    private function parseOneValue(string $s, int $start): array
    {
        if (strtoupper(substr($s, $start, 4)) === 'NULL') {
            return [null, $start + 4];
        }

        if ($s[$start] === "'") {
            $i = $start + 1;
            $chars = '';
            $len = strlen($s);

            while ($i < $len) {
                $ch = $s[$i];

                if ($ch === '\\') {
                    if ($i + 1 < $len) {
                        $next = $s[$i + 1];
                        switch ($next) {
                            case "'": $chars .= "'"; break;
                            case '"': $chars .= '"'; break;
                            case '\\': $chars .= '\\'; break;
                            case 'n': $chars .= "\n"; break;
                            case 'r': $chars .= "\r"; break;
                            case 't': $chars .= "\t"; break;
                            default: $chars .= $next; break;
                        }
                        $i += 2;
                    } else {
                        $chars .= '\\';
                        $i++;
                    }
                    continue;
                }

                if ($ch === "'") {
                    if ($i + 1 < $len && $s[$i + 1] === "'") {
                        $chars .= "'";
                        $i += 2;
                        continue;
                    }
                    return [$chars, $i + 1];
                }

                $chars .= $ch;
                $i++;
            }

            return [$chars, $i];
        }

        // Number or unquoted
        $i = $start;
        $len = strlen($s);
        while ($i < $len && $s[$i] !== ',' && $s[$i] !== ')' &&
               $s[$i] !== ' ' && $s[$i] !== "\t" &&
               $s[$i] !== "\n" && $s[$i] !== "\r") {
            $i++;
        }

        $val = substr($s, $start, $i - $start);
        if (is_numeric($val)) {
            return [$val + 0, $i];
        }
        return [$val, $i];
    }
}
