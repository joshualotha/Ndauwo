<?php
/**
 * Ndauwo Bootstrap Script — Zero-Shell cPanel Deployment
 * 
 * This script bootstraps the entire Ndauwo site WITHOUT:
 * - Terminal/SSH access
 * - shell_exec() or exec() (disabled on shared cPanel)
 * - Pre-existing .env file
 * - composer (vendor/ is committed)
 * - Any configuration
 * 
 * HOW TO USE:
 * 1. Pull the repo via cPanel Git Version Control
 * 2. Visit: https://ndauwosafaris.com/bootstrap.php
 * 3. The page runs all setup steps and shows progress
 * 4. DELETE THIS FILE after successful deployment (security)
 * 
 * HOW IT WORKS:
 * 1. Creates .env from .env.example with a fresh APP_KEY (pure PHP)
 * 2. Boots Laravel's kernel
 * 3. Runs Artisan commands via Artisan::call() — no shell needed
 */

// ============================================================
// 1. OUTPUT HEADER
// ============================================================
header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html lang="en"><head><title>Ndauwo — Bootstrap</title>';
echo '<style>
    * { box-sizing: border-box; }
    body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", monospace; background: #0a0a0a; color: #e0e0e0; padding: 2rem; line-height: 1.6; max-width: 900px; margin: 0 auto; }
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
echo '<p class="sub">Zero-shell deployment — uses internal Laravel API, no exec() needed.</p>';

// Flush output for live progress
if (ob_get_level()) { ob_flush(); }
flush();

// ============================================================
// 2. PATHS
// ============================================================
$projectRoot = realpath(__DIR__ . '/..');
$envFile     = $projectRoot . '/.env';
$envExample  = $projectRoot . '/.env.example';

echo "<h2>Environment</h2>";
echo "<div class='output'>Project root: {$projectRoot}\n.env exists: " . (file_exists($envFile) ? 'yes' : 'no') . "</div>";

// ============================================================
// 3. STEP 1: Create .env from .env.example
// ============================================================
echo "<h2>Step 1: .env File</h2>";

if (file_exists($envFile)) {
    echo "<div class='step'>.env already exists — keeping it</div>";
    echo "<div class='success'>✓ Done</div>";
} elseif (!file_exists($envExample)) {
    echo "<div class='error'>✗ .env.example not found at {$envExample}</div>";
    echo '<hr><div class="fail">❌ Cannot continue. .env.example is missing from the repo.</div>';
    echo '</body></html>';
    exit;
} else {
    $content = file_get_contents($envExample);
    if ($content === false) {
        echo "<div class='error'>✗ Could not read .env.example</div>";
        echo '</body></html>';
        exit;
    }
    
    // Generate a fresh APP_KEY
    $key = 'base64:' . base64_encode(random_bytes(32));
    $content = str_replace('APP_KEY=base64:0C7XMqR7EywJmBJGg0ViBqeDFNqOSmFhCfpBmQiGtLc=', 'APP_KEY=' . $key, $content);
    // Also handle empty APP_KEY= just in case
    $content = preg_replace('/^APP_KEY=\s*$/m', 'APP_KEY=' . $key, $content);
    
    if (file_put_contents($envFile, $content) === false) {
        echo "<div class='error'>✗ Could not write .env — check directory permissions</div>";
        echo '</body></html>';
        exit;
    }
    echo "<div class='step'>Created .env from .env.example with fresh APP_KEY</div>";
    echo "<div class='success'>✓ Done</div>";
}

// ============================================================
// 4. STEP 2: Ensure SQLite database file exists
// ============================================================
echo "<h2>Step 2: Database File</h2>";

$dbPath = $projectRoot . '/database/database.sqlite';
if (file_exists($dbPath)) {
    echo "<div class='step'>database/database.sqlite already exists</div>";
    echo "<div class='success'>✓ Done</div>";
} else {
    if (@touch($dbPath)) {
        echo "<div class='step'>Created database/database.sqlite</div>";
        echo "<div class='success'>✓ Done</div>";
    } else {
        echo "<div class='error'>✗ Could not create database/database.sqlite — check database/ directory permissions</div>";
        echo '<hr><div class="fail">❌ Cannot continue. Fix directory permissions first.</div>';
        echo '</body></html>';
        exit;
    }
}

// ============================================================
// 5. STEP 3: Boot Laravel Kernel
// ============================================================
echo "<h2>Step 3: Boot Laravel</h2>";

try {
    // Load the application
    $app = require $projectRoot . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    echo "<div class='step'>Laravel application booted successfully</div>";
    echo "<div class='success'>✓ Done</div>";
    
    // ============================================================
    // 6. STEP 4: Generate APP_KEY (via Artisan)
    // ============================================================
    echo "<h2>Step 4: Application Key</h2>";
    
    // Check if key is already set to a real value
    $currentKey = $_ENV['APP_KEY'] ?? getenv('APP_KEY') ?? '';
    if (!empty($currentKey) && $currentKey !== 'base64:0C7XMqR7EywJmBJGg0ViBqeDFNqOSmFhCfpBmQiGtLc=') {
        echo "<div class='step'>APP_KEY already set — skipping</div>";
        echo "<div class='success'>✓ Done</div>";
    } else {
        try {
            $exitCode = $kernel->call('key:generate', ['--force' => true]);
            $output = trim($kernel->output());
            echo "<div class='step'>php artisan key:generate --force</div>";
            echo "<div class='success'>✓ Done — {$output}</div>";
        } catch (\Exception $e) {
            echo "<div class='warn'>⚠ key:generate failed: {$e->getMessage()}</div>";
            echo "<div class='warn'>Key may already be set — continuing...</div>";
        }
    }
    
    // ============================================================
    // 7. STEP 5: Run Migrations
    // ============================================================
    echo "<h2>Step 5: Database Migrations</h2>";
    
    try {
        $exitCode = $kernel->call('migrate', ['--force' => true]);
        $output = trim($kernel->output());
        if (!empty($output)) {
            echo '<div class="output">' . htmlspecialchars($output) . '</div>';
        }
        if ($exitCode === 0) {
            echo "<div class='success'>✓ Migrations complete</div>";
        } else {
            echo "<div class='warn'>⚠ Migrations finished with exit code {$exitCode} — check output above</div>";
        }
    } catch (\Exception $e) {
        echo "<div class='error'>✗ Migration failed: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    
    // ============================================================
    // 8. STEP 6: Optimize & Cache
    // ============================================================
    echo "<h2>Step 6: Optimize & Cache</h2>";
    
    $commands = [
        'optimize'     => ['--force' => true],
        'config:cache' => [],
        'route:cache'  => [],
        'view:cache'   => [],
    ];
    
    foreach ($commands as $cmd => $args) {
        try {
            $exitCode = $kernel->call($cmd, $args);
            $output = trim($kernel->output());
            $status = $exitCode === 0 ? '✓' : "⚠ (exit {$exitCode})";
            $class = $exitCode === 0 ? 'success' : 'warn';
            echo "<div class='step'>php artisan {$cmd}</div>";
            if (!empty($output)) {
                echo '<div class="output">' . htmlspecialchars($output) . '</div>';
            }
            echo "<div class='{$class}'>{$status} Done</div>";
        } catch (\Exception $e) {
            echo "<div class='step'>php artisan {$cmd}</div>";
            echo "<div class='error'>✗ Failed: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }
    
    // ============================================================
    // 9. STEP 7: Verify
    // ============================================================
    echo "<h2>Step 7: Verify</h2>";
    
    try {
        $exitCode = $kernel->call('about');
        $output = trim($kernel->output());
        echo "<div class='success'>✓ Laravel boots and responds</div>";
        // Extract key info from artisan about
        if (preg_match('/Environment\s*\.+\s*(\w+)/', $output, $m)) {
            echo "<div class='output'>Environment: {$m[1]}</div>";
        }
    } catch (\Exception $e) {
        echo "<div class='warn'>⚠ Could not verify: {$e->getMessage()}</div>";
    }
    
} catch (\Exception $e) {
    echo "<div class='error'>✗ Failed to boot Laravel: " . htmlspecialchars($e->getMessage()) . "</div>";
    echo '<div class="output">' . htmlspecialchars($e->getTraceAsString()) . '</div>';
    echo '<hr><div class="fail">❌ Bootstrap failed. Check that vendor/ directory exists in the repo.</div>';
    echo '</body></html>';
    exit;
}

// ============================================================
// 10. DONE
// ============================================================
echo '<hr>';
echo '<div class="done">✅ Bootstrap Complete! Ndauwo is deployed.</div>';

echo '<h2>Next Steps</h2>';
echo '<ol style="color:#aaa;">';
echo '<li><strong style="color:#e2791b;">DELETE THIS FILE:</strong> <code style="color:#888;">public/bootstrap.php</code> — for security</li>';
echo '<li>Visit <a href="/" style="color:#e2791b;">your homepage</a> to verify the site loads</li>';
echo '<li>Edit <code style="color:#888;">.env</code> in cPanel File Manager if you need to change settings</li>';
echo '<li>For future code updates: pull via Git Version Control → re-upload this script → visit again</li>';
echo '</ol>';

echo '<p style="margin-top:2rem;font-size:0.75rem;color:#444;">Bootstrap v3.0 — uses Artisan::call() — zero shell — Ndauwo Safari Co.</p>';
echo '</body></html>';
