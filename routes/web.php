<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\VideoSectionController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Contact Form
Route::post('/contact/submit', [ContactController::class, 'submit'])
    ->name('contact.submit');




/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Guest Routes
        |--------------------------------------------------------------------------
        */

        Route::middleware('guest')->group(function () {

            Route::get('/login', [AuthController::class, 'showLogin'])
                ->name('login');

            Route::post('/login', [AuthController::class, 'login'])
                ->name('login.submit');
        });

        /*
        |--------------------------------------------------------------------------
        | Authenticated Routes
        |--------------------------------------------------------------------------
        */

        Route::middleware('auth')->group(function () {

            // Dashboard
            Route::view('/dashboard', 'backend.pages.dashboard')
                ->name('dashboard');

            // Profile
            Route::put('/profile/update', [ProfileController::class, 'update'])
                ->name('profile.update');

            // Video Sections
            Route::resource('video-sections', VideoSectionController::class)
                ->except('show');

            // Contact Enquiries
            Route::get('/contacts', [ContactController::class, 'index'])
                ->name('contacts.index');

            // Logout
            Route::post('/logout', [AuthController::class, 'logout'])
                ->name('logout');
        });
    });