<?php

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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::get('/logout', [UserProfileController::class, 'destroy'])->name('user-logout');
    // Profile
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::post('/profile/change-profile', [UserProfileController::class, 'changeProfile'])->name('change-profile');
    Route::post('/profile/change-password', [UserProfileController::class, 'updatePassword'])->name('change-password');
    Route::post('/profile/change-profile-picture', [UserProfileController::class, 'changeProfilePicture'])->name('change-profile-picture');
});

require __DIR__ . '/auth.php';
