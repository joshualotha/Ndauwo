<?php

use Illuminate\Support\Facades\Route;

// Catch-all for SPA — serves app.blade.php for all non-API paths
// The regex ensures /api/* and /sanctum/* routes are NOT caught
Route::get('/{any?}', function () {
    return view('app');
})->where('any', '^(?!api|sanctum).*$');
