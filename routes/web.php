<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\VideoSectionController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Default Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect()->route('admin.login');

});


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

            Route::get(
                '/login',
                [AuthController::class, 'showLogin']
            )->name('login');


            Route::post(
                '/login',
                [AuthController::class, 'login']
            )->name('login.submit');

        });


        /*
        |--------------------------------------------------------------------------
        | Protected Admin Routes
        |--------------------------------------------------------------------------
        */

        Route::middleware('auth')->group(function () {


            /*
            |--------------------------------------------------------------------------
            | Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', function () {

                return view('backend.pages.dashboard');

            })->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | Video Section CRUD
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'video-sections',
                VideoSectionController::class
            )->except('show');


            /*
            |--------------------------------------------------------------------------
            | Logout
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/logout',
                [AuthController::class, 'logout']
            )->name('logout');

        });

    });