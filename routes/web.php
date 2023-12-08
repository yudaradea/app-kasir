<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
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
        Route::get('/category/{id}', 'show')->name('category.show');
        Route::post('/category', 'store')->name('category.store');
        Route::post('/category/{id}', 'update')->name('category.update');
        Route::delete('/category/{id}', 'destroy')->name('category.destroy');
    });

    // produk
    Route::post('/product/hapus-selected', [ProductController::class, 'hapusSelected'])->name('produk.hapus.selected');
    Route::post('/product/cetak-barcode/{id}', [ProductController::class, 'cetakBarcode'])->name('produk.cetak.barcode');
    Route::resource('/product', ProductController::class);

    // member
    Route::post('/member/cetak-barcode/{id}', [MemberController::class, 'cetakBarcode'])->name('member.cetak.barcode');
    Route::resource('/member', MemberController::class);
});

require __DIR__ . '/auth.php';
