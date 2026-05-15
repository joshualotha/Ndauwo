<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\GalleryItemController; // Added based on the example, assuming it's not in Api namespace
use Illuminate\Support\Facades\Route; // Re-added this as it's used later
use App\Http\Controllers\Api\AuthController; // Re-added this as it's used later

Route::post('/login', [AuthController::class, 'login']);

Route::post('/inquiries', [InquiryController::class, 'store']); // Public inquiry submission

// Reviews
Route::get('/reviews', [ReviewController::class, 'index']);

// Gallery
Route::get('/gallery', [GalleryItemController::class, 'index']);
Route::get('/gallery/{galleryItem}', [GalleryItemController::class, 'show']);
Route::post('/gallery/upload', [GalleryItemController::class, 'upload']);
Route::post('/gallery', [GalleryItemController::class, 'store']);
Route::put('/gallery/{galleryItem}', [GalleryItemController::class, 'update']);
Route::delete('/gallery/{galleryItem}', [GalleryItemController::class, 'destroy']);

// Global Page Images
Route::get('/page-images/all', [\App\Http\Controllers\Api\PageImageController::class, 'all']);
Route::get('/page-images/{page}', [\App\Http\Controllers\Api\PageImageController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Page Images (Admin)
    Route::post('/admin/page-images', [\App\Http\Controllers\Api\PageImageController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    Route::apiResource('packages', \App\Http\Controllers\Api\PackageController::class)->except(['index', 'show']);
    Route::apiResource('destinations', \App\Http\Controllers\Api\DestinationController::class)->except(['index', 'show']);
    Route::apiResource('posts', \App\Http\Controllers\Api\PostController::class)->except(['index', 'show']);
    Route::get('/admin/posts', [\App\Http\Controllers\Api\PostController::class, 'adminIndex']);
    
    // Inquiries & Bookings
    Route::apiResource('inquiries', \App\Http\Controllers\Api\InquiryController::class);
    Route::post('/inquiries/{id}/convert', [\App\Http\Controllers\Api\InquiryController::class, 'convertToBooking']);
    Route::apiResource('bookings', \App\Http\Controllers\Api\BookingController::class);

    // Reviews
    Route::get('/admin/reviews', [\App\Http\Controllers\Api\ReviewController::class, 'index']); // For list with 'all'
    Route::post('/reviews/{id}/toggle', [\App\Http\Controllers\Api\ReviewController::class, 'toggleActive']);
    Route::delete('/reviews/{id}', [\App\Http\Controllers\Api\ReviewController::class, 'destroy']);

    // Media Routes
    Route::get('/media', [\App\Http\Controllers\Api\MediaController::class, 'index']);
    Route::post('/media', [\App\Http\Controllers\Api\MediaController::class, 'store']);
    Route::delete('/media', [\App\Http\Controllers\Api\MediaController::class, 'destroy']);

    // System Management
    Route::get('/system/health', [\App\Http\Controllers\Api\SystemController::class, 'health']);
    Route::post('/system/cache', [\App\Http\Controllers\Api\SystemController::class, 'clearCache']);
    Route::get('/system/logs', [\App\Http\Controllers\Api\SystemController::class, 'getLogs']);
    Route::post('/system/backup', [\App\Http\Controllers\Api\SystemController::class, 'backup']);
    
    // Admin Newsletter
    Route::get('/newsletter', [\App\Http\Controllers\Api\NewsletterController::class, 'index']);

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Api\DashboardController::class, 'index']);

    // Secured Settings Operations
    Route::post('/settings', [\App\Http\Controllers\Api\SettingController::class, 'update']);
    Route::post('/settings/upload', [\App\Http\Controllers\Api\SettingController::class, 'upload']);
});

// Public Routes
Route::get('/settings', [\App\Http\Controllers\Api\SettingController::class, 'index']); // Public settings for Analytics/SEO
Route::get('/packages', [\App\Http\Controllers\Api\PackageController::class, 'index']);
Route::get('/packages/{slug}', [\App\Http\Controllers\Api\PackageController::class, 'show']);
Route::get('/destinations', [\App\Http\Controllers\Api\DestinationController::class, 'index']);
Route::get('/destinations/{slug}', [\App\Http\Controllers\Api\DestinationController::class, 'show']);
Route::get('/posts', [\App\Http\Controllers\Api\PostController::class, 'index']);
Route::get('/posts/{slug}', [\App\Http\Controllers\Api\PostController::class, 'show']);

// Search & Newsletter (Public)
Route::get('/search', [\App\Http\Controllers\Api\SearchController::class, 'search']);
Route::post('/newsletter', [\App\Http\Controllers\Api\NewsletterController::class, 'store']);

// Sitemaps (Public)
Route::get('/sitemap.xml', [\App\Http\Controllers\Api\SitemapController::class, 'index']);
Route::get('/sitemap-static.xml', [\App\Http\Controllers\Api\SitemapController::class, 'static']);
Route::get('/sitemap-packages.xml', [\App\Http\Controllers\Api\SitemapController::class, 'packages']);
Route::get('/sitemap-destinations.xml', [\App\Http\Controllers\Api\SitemapController::class, 'destinations']);
Route::get('/sitemap-posts.xml', [\App\Http\Controllers\Api\SitemapController::class, 'posts']);
