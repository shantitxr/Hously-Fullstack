<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPropertyController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PropertyController as UserPropertyController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\InquiryController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/properties/{property}', [PropertyController::class, 'show'])
    ->name('properties.show');

// ─── Auth Routes ──────────────────────────────────────────────────────────────

require __DIR__.'/auth.php';

// ─── Authenticated User Routes ────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Properties
    Route::get('/user/properties',                   [UserPropertyController::class, 'index'])->name('user.properties.index');
    Route::get('/user/properties/create',            [UserPropertyController::class, 'create'])->name('user.properties.create');
    Route::post('/user/properties',                  [UserPropertyController::class, 'store'])->name('user.properties.store');
    Route::get('/user/properties/{property}/edit',   [UserPropertyController::class, 'edit'])->name('user.properties.edit');
    Route::post('/user/properties/{property}',       [UserPropertyController::class, 'update'])->name('user.properties.update');
    Route::delete('/user/properties/{property}',     [UserPropertyController::class, 'destroy'])->name('user.properties.destroy');
    Route::delete('/user/properties/images/{image}', [UserPropertyController::class, 'destroyImage'])->name('user.properties.images.destroy');

    // Wishlist
    Route::get('/wishlist',              [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{property}',  [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Inquiries
    Route::get('/inquiries',                          [InquiryController::class, 'index'])->name('inquiries.index');
    Route::post('/properties/{property}/inquiries',   [InquiryController::class, 'store'])->name('inquiries.store');
    Route::post('/inquiries/{inquiry}/read',          [InquiryController::class, 'markRead'])->name('inquiries.read');

});

// ─── Admin Routes ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/',                              [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/properties',                    [AdminPropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create',             [AdminPropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties',                   [AdminPropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit',    [AdminPropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}',         [AdminPropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}',      [AdminPropertyController::class, 'destroy'])->name('properties.destroy');

    Route::get('/users',                         [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}',                  [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}',               [AdminUserController::class, 'destroy'])->name('users.destroy');

});
