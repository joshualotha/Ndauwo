<?php
/**
 * Ndauwo Deployment Script
 * 
 * Purpose: Deploy updates from GitHub to cPanel WITHOUT terminal/SSH access.
 * 
 * HOW TO USE (cPanel):
 * 1. Visit: https://ndauwo.com/deploy.php?token=YOUR_SECRET_TOKEN
 * 2. Set DEPLOY_TOKEN in .env (generate: php artisan tinker --execute="echo bin2hex(random_bytes(16));")
 * 3. This script runs: git pull → composer install → artisan commands
 * 
 * SECURITY:
 * - Requires a token to execute (prevents unauthorized deploys)
 * - Token stored in .env, never committed to git
 * - Run once after initial setup or after every git push
 * - Delete or rename this file after site is fully deployed if you prefer
 * - Uses shell_exec() — cPanel typically allows this for PHP scripts
 */

// ============================================================
// 1. SECURITY CHECK — Require token to prevent abuse
// ============================================================
$requiredToken = getenv('DEPLOY_TOKEN') ?: ($_ENV['DEPLOY_TOKEN'] ?? '');
$providedToken = $_GET['token'] ?? '';

if (empty($requiredToken)) {
    http_response_code(500);
    die("<h2>Error: DEPLOY_TOKEN not set</h2>
         <p>Add <code>DEPLOY_TOKEN=your-secret-token</code> to your <code>.env</code> file first.</p>
         <p>Generate a token: <code>php artisan tinker --execute=\"echo bin2hex(random_bytes(16));\"</code></p>");
}

if (!hash_equals($requiredToken, $providedToken)) {
    http_response_code(403);
    die("<h2>Access Denied</h2><p>Invalid or missing deploy token.</p>");
}

// ============================================================
// 2. OUTPUT HEADER
// ============================================================
header('Content-Type: text/html; charset=utf-8');
echo '<!DOCTYPE html><html lang="en"><head><title>Ndauwo Deploy</title>';
echo '<style>
    body { font-family: "SF Mono", "Monaco", "Menlo", monospace; background: #0a0a0a; color: #e0e0e0; padding: 2rem; line-height: 1.6; }
    h1 { color: #e2791b; border-bottom: 1px solid rgba(226,121,27,0.3); padding-bottom: 0.5rem; }
    .step { margin: 0.5rem 0; }
    .step::before { content: "▸ "; color: #e2791b; }
    .success { color: #4ade80; }
    .error { color: #f87171; font-weight: bold; }
    .output { background: #1a1a1a; border-left: 3px solid #e2791b; padding: 0.5rem 1rem; margin: 0.25rem 0; white-space: pre-wrap; font-size: 0.85rem; color: #888; }
    .done { color: #4ade80; font-weight: bold; margin-top: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #4ade80; display: inline-block; }
    .warn { color: #e2791b; }
</style></head><body>';
echo '<h1>🦁 Ndauwo Safari Co. — Deployment</h1>';
echo '<p>Running deployment commands...</p>';

// Flush output so the user sees progress
if (ob_get_level()) { ob_flush(); }
flush();

// ============================================================
// 3. HELPER — Run a command and show output
// ============================================================
function runCommand(string $label, string $command): bool {
    echo "<div class='step'>{$label}</div>";
    
    // Execute the command
    $output = [];
    $returnCode = -1;
    $fullCmd = "{$command} 2>&1";
    exec($fullCmd, $output, $returnCode);
    
    // Show output
    if (!empty($output)) {
        echo '<div class="output">' . htmlspecialchars(implode("\n", $output)) . '</div>';
    }
    
    if ($returnCode !== 0) {
        echo "<div class='error'>✗ Failed (exit code: {$returnCode})</div>";
        return false;
    }
    echo "<div class='success'>✓ Done</div>";
    return true;
}

// ============================================================
// 4. DETECT PATHS
// ============================================================
$projectRoot = __DIR__ . '/..';  // deploy.php is in public/, project root is one level up

// Determine PHP binary path (cPanel typically has this)
$php = trim(shell_exec('which php 2>/dev/null') ?: '/usr/local/bin/php');
$composer = trim(shell_exec('which composer 2>/dev/null') ?: '/usr/local/bin/composer');
$git = trim(shell_exec('which git 2>/dev/null') ?: '/usr/local/bin/git');

echo "<div class='output'>Project root: {$projectRoot}\nPHP: {$php}\nComposer: {$composer}\nGit: {$git}</div>";

// ============================================================
// 5. DEPLOYMENT STEPS
// ============================================================
$allOK = true;
$chdir = "cd " . escapeshellarg($projectRoot) . " && ";

// Step 1: Create .env from .env.example if it doesn't exist (it's gitignored)
$envFile = $projectRoot . '/.env';
$envExample = $projectRoot . '/.env.example';
if (!file_exists($envFile) && file_exists($envExample)) {
    $copied = copy($envExample, $envFile);
    if ($copied) {
        echo "<div class='step'>Created .env from .env.example</div>";
        echo "<div class='success'>✓ Done — .env created. You MUST edit it with your MySQL credentials and APP_URL.</div>";
        echo "<div class='warn'>⚠ Edit .env now: DB_CONNECTION=mysql, DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL</div>";
    } else {
        echo "<div class='step'>Failed to create .env from .env.example</div>";
        echo "<div class='error'>✗ Could not copy .env.example → .env. Check file permissions.</div>";
        $allOK = false;
    }
} else if (file_exists($envFile)) {
    echo "<div class='step'>.env already exists — skipping creation</div>";
    echo "<div class='success'>✓ Done</div>";
}

// Step 2: Git pull (skip if .env creation failed)
if ($allOK) {
    $allOK = runCommand("git pull origin main", "{$chdir}{$git} pull origin main 2>&1") && $allOK;
}

// Step 3: Composer install (production-safe: no dev deps)
if ($allOK) {
    $allOK = runCommand("composer install (no dev)", "{$chdir}{$composer} install --no-dev --optimize-autoloader --no-interaction 2>&1") && $allOK;
}

// Step 4: Generate application key (critical — Laravel won't boot without it)
if ($allOK) {
    $allOK = runCommand("php artisan key:generate --force", "{$chdir}{$php} artisan key:generate --force --no-interaction 2>&1") && $allOK;
}

// Step 5: Run database migrations
if ($allOK) {
    $allOK = runCommand("php artisan migrate", "{$chdir}{$php} artisan migrate --force --no-interaction 2>&1") && $allOK;
}

// Step 6: Laravel optimize
if ($allOK) {
    $allOK = runCommand("php artisan optimize", "{$chdir}{$php} artisan optimize 2>&1") && $allOK;
}

// Step 7: Cache configuration
if ($allOK) {
    $allOK = runCommand("php artisan config:cache", "{$chdir}{$php} artisan config:cache 2>&1") && $allOK;
    $allOK = runCommand("php artisan route:cache", "{$chdir}{$php} artisan route:cache 2>&1") && $allOK;
    $allOK = runCommand("php artisan view:cache", "{$chdir}{$php} artisan view:cache 2>&1") && $allOK;
}

// ============================================================
// 6. FINAL STATUS
// ============================================================
echo '<hr>';
if ($allOK) {
    echo '<div class="done">✅ Deployment Complete! Ndauwo Safari Co. is now live.</div>';
    echo '<p class="success">All steps passed. The site is updated with the latest code from GitHub.</p>';
} else {
    echo '<div class="error">❌ Deployment had errors. Check the output above for details.</div>';
    echo '<p class="warn">Some steps may have failed. You can re-run this page to retry.</p>';
}

echo '<p style="margin-top:2rem;font-size:0.8rem;color:#555;">Deploy script v1.0 — Ndauwo Safari Co.</p>';
echo '</body></html>';
