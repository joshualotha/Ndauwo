<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class SystemController extends Controller
{
    /**
     * Get system health status.
     */
    public function health()
    {
        // Database Connection
        try {
            DB::connection()->getPdo();
            $dbStatus = 'Connected';
        } catch (\Exception $e) {
            $dbStatus = 'Disconnected: ' . $e->getMessage();
        }

        // Disk Usage
        $diskTotal = disk_total_space('/');
        $diskFree = disk_free_space('/');
        $diskUsed = $diskTotal - $diskFree;
        $diskUsage = round(($diskUsed / $diskTotal) * 100, 2);

        return response()->json([
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
            'database_status' => $dbStatus,
            'disk_usage' => $diskUsage . '%',
            'server_time' => now()->toDateTimeString(),
            'debug_mode' => config('app.debug'),
            'environment' => app()->environment(),
        ]);
    }

    /**
     * Clear system caches.
     */
    public function clearCache(Request $request)
    {
        $type = $request->input('type', 'all');
        
        try {
            switch ($type) {
                case 'config':
                    Artisan::call('config:clear');
                    break;
                case 'route':
                    Artisan::call('route:clear');
                    break;
                case 'view':
                    Artisan::call('view:clear');
                    break;
                case 'cache':
                    Artisan::call('cache:clear');
                    break;
                case 'all':
                    Artisan::call('optimize:clear');
                    break;
            }
            return response()->json(['message' => 'Cache cleared successfully (' . $type . ')']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to clear cache: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get recent logs.
     */
    public function getLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!File::exists($logFile)) {
            return response()->json(['logs' => []]);
        }

        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $recentLogs = array_slice($lines, -50); // Get last 50 lines
        $recentLogs = array_reverse($recentLogs); // Show newest first

        return response()->json(['logs' => $recentLogs]);
    }

    /**
     * Trigger database backup.
     */
    public function backup()
    {
        // Simple backup logic using mysqldump
        $filename = 'backup-' . now()->format('Y-m-d-H-i-s') . '.sql';
        $path = storage_path('app/backups/' . $filename);
        
        // Ensure directory exists
        if (!File::exists(storage_path('app/backups'))) {
            File::makeDirectory(storage_path('app/backups'), 0755, true);
        }

        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password'); // Be careful with password visibility in process list if on shared hosting, but ok for VPS/Local
        $dbHost = config('database.connections.mysql.host');

        // Note: Password can be tricky to pass via command line securely. 
        // For simplicity in this demo environment:
        $command = "mysqldump --user={$dbUser} --password={$dbPass} --host={$dbHost} {$dbName} > {$path}";
        
        // On some systems, putting password in command might trigger warning.
        // A safer way is using configuring .my.cnf, but let's try basic execution first.
        
        // If password is empty, don't include it
        if (empty($dbPass)) {
            $command = "mysqldump --user={$dbUser} --host={$dbHost} {$dbName} > {$path}";
        }

        // Executing shell command
        // Note: This requires mysqldump to be in PATH
        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            return response()->json(['message' => 'Backup created successfully', 'file' => $filename]);
        } else {
            return response()->json(['message' => 'Backup failed', 'output' => $output], 500);
        }
    }
}
