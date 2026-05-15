<?php

/**
 * Laravel Custom Router for PHP Built-in Server
 * ==============================================
 *
 * This router ensures ALL requests pass through Laravel's front controller
 * (public/index.php), preventing PHP's built-in server from returning its
 * own 404 for directories without index files (e.g., /build/).
 *
 * Usage:
 *   php -S localhost:8000 -t public server.php
 *
 * Logic:
 *   - If the URI maps to an actual FILE on disk, PHP serves it directly.
 *   - If the URI maps to a directory OR doesn't exist as a file, the
 *     request goes to index.php where Laravel's catch-all route handles it.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

$publicPath = __DIR__ . '/public' . $uri;

// Only let PHP's built-in server handle actual files (CSS, JS, images, etc.).
// Directories (like /build/) must go through Laravel to avoid PHP's 404.
if ($uri !== '/' && is_file($publicPath)) {
    return false;
}

// Everything else — directories, SPA routes, 404s — goes through Laravel
require_once __DIR__ . '/public/index.php';
