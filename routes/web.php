<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/properties/{property}', function ($property) {
    // Replace with: return view('property-detail', ['property' => Property::findOrFail($property)]);
    return view('property-detail', ['property' => (object)['id' => $property]]);
})->name('properties.show');

// ─── Auth Routes (login, register, etc.) ─────────────────────────────────────

require __DIR__.'/auth.php';

// ─── Authenticated User Routes ────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function () {

    // User Dashboard
    Route::get('/dashboard', function () {
        return view('user.dashboard', [
            'totalProperties'  => 0,
            'totalWishlist'    => 0,
            'totalInquiries'   => 0,
            'recentProperties' => collect(),
            'recentInquiries'  => collect(),
        ]);
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Properties
    Route::get('/user/properties', function () {
        return view('user.my-properties', ['properties' => collect()]);
    })->name('user.properties.index');

    Route::get('/user/properties/create', function () {
        return view('user.create-property');
    })->name('user.properties.create');

    Route::post('/user/properties', function () {
        return redirect()->route('user.properties.index');
    })->name('user.properties.store');

    Route::get('/user/properties/{property}/edit', function ($property) {
        return view('user.edit-property', [
            'property' => (object)['id' => $property, 'images' => collect()]
        ]);
    })->name('user.properties.edit');

    Route::post('/user/properties/{property}', function ($property) {
        return redirect()->route('user.properties.index');
    })->name('user.properties.update');

    Route::delete('/user/properties/{property}', function ($property) {
        return redirect()->route('user.properties.index');
    })->name('user.properties.destroy');

    Route::delete('/user/properties/images/{image}', function ($image) {
        return back();
    })->name('user.properties.images.destroy');

    // Wishlist
    Route::get('/wishlist', function () {
        return view('user.wishlist', ['properties' => collect()]);
    })->name('wishlist.index');

    Route::post('/wishlist/{property}', function ($property) {
        return back();
    })->name('wishlist.toggle');

    // Inquiries
    Route::get('/inquiries', function () {
        return view('user.inquiries', ['inquiries' => collect()]);
    })->name('inquiries.index');

    Route::post('/properties/{property}/inquiries', function ($property) {
        return back();
    })->name('inquiries.store');

    Route::post('/inquiries/{inquiry}/read', function ($inquiry) {
        return back();
    })->name('inquiries.read');

});

// ─── Admin Routes ─────────────────────────────────────────────────────────────

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function () {
        return view('admin.admin-dashboard', [
            'totalProperties'  => 0,
            'totalUsers'       => 0,
            'totalInquiries'   => 0,
            'recentProperties' => collect(),
            'recentUsers'      => collect(),
        ]);
    })->name('dashboard');

    Route::get('/properties', function () {
        return view('admin.admin-properties', ['properties' => collect()]);
    })->name('properties.index');

    Route::get('/properties/create', function () {
        return view('admin.admin-properties', ['properties' => collect()]);
    })->name('properties.create');

    Route::get('/properties/{property}/edit', function ($property) {
        return view('admin.admin-properties', ['properties' => collect()]);
    })->name('properties.edit');

    Route::delete('/properties/{property}', function ($property) {
        return redirect()->route('admin.properties.index');
    })->name('properties.destroy');

    Route::get('/users', function () {
        return view('admin.admin-users', ['users' => collect()]);
    })->name('users.index');

    Route::put('/users/{user}', function ($user) {
        return back();
    })->name('users.update');

    Route::delete('/users/{user}', function ($user) {
        return redirect()->route('admin.users.index');
    })->name('users.destroy');

});
