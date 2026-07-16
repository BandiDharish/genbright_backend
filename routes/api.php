<?php

use App\Http\Controllers\Api\VideoSectionController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Contact form API
Route::post('/contact/submit', [ContactController::class, 'submit']);

// Video section APIs
Route::get('/video-sections', [VideoSectionController::class, 'index']);

Route::get('/video-sections/{videoSection}', [
    VideoSectionController::class,
    'show',
]);