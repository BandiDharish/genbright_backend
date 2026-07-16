<?php

use App\Http\Controllers\Api\VideoSectionController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::post('/contact/submit', [ContactController::class, 'submit']);
Route::get('/video-sections', [VideoSectionController::class, 'index']);