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
use App\Models\Property;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', function () {
    $properties = Property::where('is_available', true)
        ->when(request('search'), fn($q) =>
            $q->where('title', 'like', '%'.request('search').'%')
              ->orWhere('city', 'like', '%'.request('search').'%'))
        ->when(request('type'), fn($q) => $q->where('property_type', request('type')))
        ->when(request('listing_type'), fn($q) => $q->where('listing_type', request('listing_type')))
        ->latest()->paginate(12);

    $wishlistIds = auth()->check()
        ? auth()->user()->wishlist()->pluck('properties.id')->toArray()
        : [];

    return view('index', compact('properties', 'wishlistIds'));
})->name('home');

Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

require __DIR__.'/auth.php';

// Authenticated (all roles)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Regular users only (admins blocked by middleware)
Route::middleware(['auth', 'not.admin'])->group(function () {
    Route::get('/user/properties',                 [UserPropertyController::class, 'index'])->name('user.properties.index');
    Route::get('/user/properties/create',          [UserPropertyController::class, 'create'])->name('user.properties.create');
    Route::post('/user/properties',                [UserPropertyController::class, 'store'])->name('user.properties.store');
    Route::get('/user/properties/{property}/edit', [UserPropertyController::class, 'edit'])->name('user.properties.edit');
    Route::post('/user/properties/{property}',     [UserPropertyController::class, 'update'])->name('user.properties.update');
    Route::delete('/user/properties/{property}',   [UserPropertyController::class, 'destroy'])->name('user.properties.destroy');

    Route::get('/wishlist',             [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{property}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    Route::get('/inquiries',                        [InquiryController::class, 'index'])->name('inquiries.index');
    Route::post('/properties/{property}/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
    Route::post('/inquiries/{inquiry}/read',        [InquiryController::class, 'markRead'])->name('inquiries.read');
});

// Admin only
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',                           [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/properties',                 [AdminPropertyController::class, 'index'])->name('properties.index');
    Route::get('/properties/create',          [AdminPropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties',                [AdminPropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [AdminPropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}',      [AdminPropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}',   [AdminPropertyController::class, 'destroy'])->name('properties.destroy');
    Route::get('/users',           [AdminUserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}',    [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});