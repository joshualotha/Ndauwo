<?php
/**
 * RESCUE SCRIPT: Fix "Your local changes would be overwritten by merge" on cPanel
 * 
 * Problem: When bootstrap.php ran migrations, cPanel's Git sees database/database.sqlite
 *          as "modified locally" and refuses to git pull.
 * 
 * Solution: This script resets database/database.sqlite so git can pull cleanly.
 *           It deletes the DB, then you pull, then run bootstrap.php to recreate it.
 * 
 * HOW TO USE:
 * 1. Upload this file to public/ via cPanel File Manager
 * 2. Visit: https://ndauwosafaris.com/rescue-git.php
 * 3. Click "Reset Database" button
 * 4. Go to cPanel Git Version Control → Pull (it will work now)
 * 5. Visit bootstrap.php to recreate the database
 * 6. DELETE THIS FILE
 */

$projectRoot = realpath(__DIR__ . '/..');
$dbPath = $projectRoot . '/database/database.sqlite';
$action = $_POST['action'] ?? '';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ndauwo — Git Rescue</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", monospace; background: #0a0a0a; color: #e0e0e0; padding: 2rem; line-height: 1.6; max-width: 700px; margin: 0 auto; }
        h1 { color: #e2791b; }
        .info { background: #1a1a1a; border-left: 3px solid #e2791b; padding: 1rem; margin: 1rem 0; }
        .success { color: #4ade80; font-weight: bold; }
        .error { color: #f87171; font-weight: bold; }
        .warn { color: #e2791b; }
        button { background: #e2791b; color: #fff; border: none; padding: 0.75rem 1.5rem; font-size: 1rem; cursor: pointer; margin: 0.5rem 0; }
        button:hover { background: #f08c2a; }
        code { color: #888; }
        hr { border: none; border-top: 1px solid rgba(226,121,27,0.15); margin: 1.5rem 0; }
        .done { color: #4ade80; font-weight: bold; margin-top: 1.5rem; padding: 0.5rem 1rem; border: 1px solid #4ade80; display: inline-block; }
    </style>
</head>
<body>
    <h1>🦁 Ndauwo — Git Rescue</h1>
    <p>This script fixes: <code>"Your local changes would be overwritten by merge"</code></p>

    <div class="info">
        <strong>Current State:</strong><br>
        Database file: <code><?php echo $dbPath; ?></code><br>
        Exists: <strong><?php echo file_exists($dbPath) ? 'Yes' : 'No'; ?></strong><br>
        Size: <strong><?php echo file_exists($dbPath) ? human_filesize(filesize($dbPath)) : 'N/A'; ?></strong>
    </div>

    <?php if ($action === 'reset'): ?>
        <?php
        $success = true;
        $messages = [];
        
        // 1. Delete the database file
        if (file_exists($dbPath)) {
            if (@unlink($dbPath)) {
                $messages[] = '<span class="success">✓</span> Deleted database/database.sqlite';
            } else {
                $messages[] = '<span class="error">✗</span> Could not delete database/database.sqlite';
                $success = false;
            }
        }
        
        // 2. Delete WAL and SHM files (SQLite journal files)
        foreach (['-wal', '-shm'] as $suffix) {
            $journalPath = $dbPath . $suffix;
            if (file_exists($journalPath)) {
                if (@unlink($journalPath)) {
                    $messages[] = '<span class="success">✓</span> Deleted database/database.sqlite' . $suffix;
                } else {
                    $messages[] = '<span class="warn">⚠</span> Could not delete database/database.sqlite' . $suffix;
                }
            }
        }
        
        // 3. Also clean bootstrap/cache if needed
        $cacheFiles = glob($projectRoot . '/bootstrap/cache/*.php');
        foreach ($cacheFiles as $cacheFile) {
            $basename = basename($cacheFile);
            if ($basename === '.gitignore') continue;
            if (@unlink($cacheFile)) {
                $messages[] = '<span class="success">✓</span> Cleared bootstrap/cache/' . $basename;
            }
        }
        
        foreach ($messages as $msg) {
            echo "<div style='margin:0.3rem 0;'>{$msg}</div>";
        }
        
        if ($success): ?>
            <hr>
            <div class="done">✅ Database reset complete!</div>
            <h2>Next Steps (in order):</h2>
            <ol>
                <li><strong>Go to cPanel → Git Version Control → Pull</strong> (should work now)</li>
                <li>Visit <a href="/bootstrap.php" style="color:#e2791b;">/bootstrap.php</a> to recreate the database with all data</li>
                <li><strong style="color:#f87171;">DELETE THIS FILE</strong> (<code>public/rescue-git.php</code>)</li>
            </ol>
        <?php else: ?>
            <hr>
            <div style="color:#f87171; font-weight:bold;">❌ Some cleanup steps failed. Try again or check file permissions.</div>
        <?php endif; ?>
        
    <?php else: ?>
        <p><strong>This will:</strong></p>
        <ul>
            <li>Delete <code>database/database.sqlite</code></li>
            <li>Delete any SQLite journal files (WAL/SHM)</li>
            <li>Clear bootstrap/cache (so git pull is clean)</li>
        </ul>
        <p class="warn"><strong>⚠ Your database data will be deleted.</strong> But don't worry — after pulling, bootstrap.php will recreate everything with seed data.</p>
        
        <form method="post">
            <button type="submit" name="action" value="reset" onclick="return confirm('This will DELETE your database. After this, you MUST run bootstrap.php to recreate it. Continue?')">
                Reset Database (Allow Git Pull)
            </button>
        </form>
    <?php endif; ?>
    
    <p style="margin-top:2rem;font-size:0.75rem;color:#444;">Git Rescue v1.0 — Ndauwo Safari Co.</p>
</body>
</html>

<?php
function human_filesize($bytes, $decimals = 1) {
    $size = ['B', 'KB', 'MB', 'GB'];
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $size[$factor];
}
