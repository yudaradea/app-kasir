<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/





Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');



    // User Profile Controller
    Route::controller(UserProfileController::class)->group(function () {
        // Logout
        Route::get('/logout',  'destroy')->name('user-logout');
        // Profile
        Route::get('/profile',  'index')->name('profile');
        Route::post('/profile/change-profile',  'changeProfile')->name('change-profile');
        Route::post('/profile/change-password',  'updatePassword')->name('change-password');
        Route::post('/profile/change-profile-picture',  'changeProfilePicture')->name('change-profile-picture');
    });
    // Category Controller
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category', 'index')->name('category');
        Route::get('/category/data', 'data')->name('category-data');
        Route::post('/category/post', 'store')->name('category-store');
    });
});

require __DIR__ . '/auth.php';
