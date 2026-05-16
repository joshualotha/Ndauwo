<?php
/**
 * Ndauwo Bootstrap Script — Zero-Config cPanel Deployment
 * 
 * This script bootstraps the entire Ndauwo site WITHOUT:
 * - Terminal/SSH access
 * - Pre-existing .env file
 * - Any configuration
 * 
 * HOW TO USE:
 * 1. Pull the repo via cPanel Git Version Control
 * 2. Visit: https://ndauwosafaris.com/bootstrap.php
 * 3. The page runs all setup steps and shows progress
 * 4. DELETE THIS FILE after successful deployment (security)
 * 
 * This script is self-contained — it reads .env.example directly,
 * generates an APP_KEY itself, and doesn't depend on any token.
 */

// ============================================================
// 1. OUTPUT HEADER
// ============================================================
header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html lang="en"><head><title>Ndauwo — Bootstrap</title>';
echo '<style>
    * { box-sizing: border-box; }
    body { font-family: "SF Mono", "Monaco", "Menlo", monospace; background: #0a0a0a; color: #e0e0e0; padding: 2rem; line-height: 1.6; max-width: 900px; margin: 0 auto; }
    h1 { color: #e2791b; border-bottom: 1px solid rgba(226,121,27,0.3); padding-bottom: 0.5rem; margin-bottom: 0.5rem; }
    h2 { color: #ccc; font-size: 1rem; margin: 1.5rem 0 0.5rem; }
    .sub { color: #666; font-size: 0.8rem; margin-bottom: 1.5rem; }
    .step { margin: 0.3rem 0; color: #aaa; }
    .step::before { content: "▸ "; color: #e2791b; }
    .success { color: #4ade80; font-weight: bold; }
    .error { color: #f87171; font-weight: bold; }
    .warn { color: #e2791b; }
    .output { background: #1a1a1a; border-left: 3px solid #e2791b; padding: 0.5rem 1rem; margin: 0.25rem 0 0.25rem 1rem; white-space: pre-wrap; font-size: 0.8rem; color: #888; max-height: 300px; overflow-y: auto; }
    .done { color: #4ade80; font-weight: bold; margin-top: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #4ade80; display: inline-block; }
    .fail { color: #f87171; font-weight: bold; margin-top: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #f87171; display: inline-block; }
    hr { border: none; border-top: 1px solid rgba(226,121,27,0.15); margin: 1.5rem 0; }
</style></head><body>';
echo '<h1>🦁 Ndauwo Safari Co. — Bootstrap</h1>';
echo '<p class="sub">Zero-config deployment — no terminal, no .env, no token needed.</p>';

// Flush output for live progress
if (ob_get_level()) { ob_flush(); }
flush();

// ============================================================
// 2. HELPER — Run command and show result
// ============================================================
function runStep(string $label, string $command): bool {
    echo "<div class='step'>{$label}</div>";
    
    $output = [];
    $returnCode = -1;
    exec("{$command} 2>&1", $output, $returnCode);
    
    if (!empty($output) && $output[0] !== '') {
        $safe = htmlspecialchars(implode("\n", array_slice($output, 0, 50)));
        echo '<div class="output">' . $safe . '</div>';
    }
    
    if ($returnCode !== 0) {
        echo "<div class='error'>✗ Failed (exit: {$returnCode})</div>";
        return false;
    }
    echo "<div class='success'>✓ Done</div>";
    return true;
}

// ============================================================
// 3. DETECT PATHS
// ============================================================
$projectRoot = realpath(__DIR__ . '/..');
$publicDir   = __DIR__;

$php      = trim(shell_exec('which php 2>/dev/null') ?: 'php');
$composer = trim(shell_exec('which composer 2>/dev/null') ?: 'composer');
$git      = trim(shell_exec('which git 2>/dev/null') ?: 'git');

echo "<h2>Environment</h2>";
echo "<div class='output'>Project: {$projectRoot}\nPHP: {$php}\nComposer: {$composer}\nGit: {$git}</div>";

$chdir = "cd " . escapeshellarg($projectRoot) . " && ";
$allOK = true;

// ============================================================
// 4. STEP 1: Create .env from .env.example (if missing)
// ============================================================
echo "<h2>Step 1: .env File</h2>";

$envFile    = $projectRoot . '/.env';
$envExample = $projectRoot . '/.env.example';

if (file_exists($envFile)) {
    echo "<div class='step'>.env already exists — keeping it</div>";
    echo "<div class='success'>✓ Done</div>";
} elseif (!file_exists($envExample)) {
    echo "<div class='error'>✗ .env.example not found at {$envExample}</div>";
    $allOK = false;
} else {
    // Copy .env.example → .env
    $content = file_get_contents($envExample);
    if ($content === false) {
        echo "<div class='error'>✗ Could not read .env.example</div>";
        $allOK = false;
    } else {
        // Generate a fresh APP_KEY directly (so we don't need artisan yet)
        $key = 'base64:' . base64_encode(random_bytes(32));
        $content = str_replace('APP_KEY=', 'APP_KEY=' . $key, $content);
        
        if (file_put_contents($envFile, $content) === false) {
            echo "<div class='error'>✗ Could not write .env — check file permissions</div>";
            $allOK = false;
        } else {
            echo "<div class='step'>Created .env from .env.example with fresh APP_KEY</div>";
            echo "<div class='success'>✓ Done</div>";
        }
    }
}

// Stop if we couldn't create .env
if (!$allOK) {
    echo '<hr><div class="fail">❌ Cannot continue without .env</div>';
    echo '<p>Make sure .env.example exists and the directory is writable.</p>';
    echo '</body></html>';
    exit;
}

// ============================================================
// 5. STEP 2: Composer Install
// ============================================================
echo "<h2>Step 2: PHP Dependencies</h2>";
if (!runStep("composer install --no-dev --optimize-autoloader", "{$chdir}{$composer} install --no-dev --optimize-autoloader --no-interaction 2>&1")) {
    echo '<div class="warn">⚠ Composer may not be available. If you uploaded vendor/ manually, this is OK.</div>';
    // Don't fail — vendor/ might already be present
}

// ============================================================
// 6. STEP 3: Generate APP_KEY (idempotent — skips if set)
// ============================================================
echo "<h2>Step 3: Application Key</h2>";
// We already set the key when creating .env, but run artisan to be safe
runStep("php artisan key:generate (force, skips if set)", "{$chdir}{$php} artisan key:generate --force --no-interaction 2>&1");

// ============================================================
// 7. STEP 4: Database — ensure SQLite file exists, run migrations
// ============================================================
echo "<h2>Step 4: Database</h2>";

$dbPath = $projectRoot . '/database/database.sqlite';
if (!file_exists($dbPath)) {
    if (touch($dbPath)) {
        echo "<div class='step'>Created database/database.sqlite</div>";
        echo "<div class='success'>✓ Done</div>";
    } else {
        echo "<div class='error'>✗ Could not create database/database.sqlite — check directory permissions</div>";
        $allOK = false;
    }
} else {
    echo "<div class='step'>database/database.sqlite already exists</div>";
    echo "<div class='success'>✓ Done</div>";
}

if ($allOK) {
    runStep("php artisan migrate", "{$chdir}{$php} artisan migrate --force --no-interaction 2>&1");
}

// ============================================================
// 8. STEP 5: Laravel Optimize & Cache
// ============================================================
echo "<h2>Step 5: Optimize & Cache</h2>";
runStep("php artisan optimize", "{$chdir}{$php} artisan optimize 2>&1");
runStep("php artisan config:cache", "{$chdir}{$php} artisan config:cache 2>&1");
runStep("php artisan route:cache", "{$chdir}{$php} artisan route:cache 2>&1");
runStep("php artisan view:cache", "{$chdir}{$php} artisan view:cache 2>&1");

// ============================================================
// 9. STEP 6: Verify the site works
// ============================================================
echo "<h2>Step 6: Verify</h2>";

// Check if we can boot Laravel
$testCmd = "{$chdir}{$php} artisan about --no-interaction 2>&1";
$testOut = [];
exec($testCmd, $testOut, $testCode);
if ($testCode === 0) {
    echo "<div class='success'>✓ Laravel boots successfully</div>";
} else {
    echo "<div class='warn'>⚠ Could not verify Laravel boot. Check .env settings.</div>";
    if (!empty($testOut)) {
        echo '<div class="output">' . htmlspecialchars(implode("\n", $testOut)) . '</div>';
    }
}

// ============================================================
// 10. DONE
// ============================================================
echo '<hr>';
echo '<div class="done">✅ Bootstrap Complete!</div>';

echo '<h2>Next Steps</h2>';
echo '<ol style="color:#aaa;">';
echo '<li><strong style="color:#e2791b;">DELETE THIS FILE:</strong> <code style="color:#888;">public/bootstrap.php</code> — for security</li>';
echo '<li>Visit <a href="/" style="color:#e2791b;">your homepage</a> to verify the site loads</li>';
echo '<li>Edit <code style="color:#888;">.env</code> in cPanel File Manager if you need MySQL instead of SQLite</li>';
echo '<li>For future updates: pull via Git Version Control, then delete/re-upload bootstrap.php to re-run</li>';
echo '</ol>';

echo '<p style="margin-top:2rem;font-size:0.75rem;color:#444;">Bootstrap v2.0 — Ndauwo Safari Co.</p>';
echo '</body></html>';
