<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PropertyApiController;
use App\Http\Controllers\Api\WishlistApiController;
use App\Http\Controllers\Api\InquiryApiController;
use App\Http\Controllers\Api\Admin\AdminUserApiController;
use App\Http\Controllers\Api\Admin\AdminPropertyApiController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

// ─── Public endpoints ───────────────────────────────────────────
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login',    [AuthApiController::class, 'login']);

Route::get('/properties',       [PropertyApiController::class, 'index']);
Route::get('/properties/{id}',  [PropertyApiController::class, 'show']);
Route::get('/categories',       fn() => response()->json(Category::all()));

// ─── Authenticated endpoints ────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user',    fn(\Illuminate\Http\Request $r) => response()->json($r->user()));

    // Properties (owner-scoped create/update/delete)
    Route::post('/properties',        [PropertyApiController::class, 'store']);
    Route::put('/properties/{id}',    [PropertyApiController::class, 'update']);
    Route::delete('/properties/{id}', [PropertyApiController::class, 'destroy']);

    // Wishlist
    Route::get('/wishlist',         [WishlistApiController::class, 'index']);
    Route::post('/wishlist/{id}',   [WishlistApiController::class, 'toggle']);

    // Inquiries
    Route::get('/inquiries',              [InquiryApiController::class, 'index']);
    Route::post('/inquiries',             [InquiryApiController::class, 'store']);
    Route::patch('/inquiries/{id}',       [InquiryApiController::class, 'markRead']);
    Route::delete('/inquiries/{id}',      [InquiryApiController::class, 'destroy']);
});

// ─── Admin-only endpoints ────────────────────────────────────────
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users',           [AdminUserApiController::class, 'index']);
    Route::put('/users/{id}',      [AdminUserApiController::class, 'update']);
    Route::delete('/users/{id}',   [AdminUserApiController::class, 'destroy']);

    Route::get('/properties',         [AdminPropertyApiController::class, 'index']);
    Route::put('/properties/{id}',    [AdminPropertyApiController::class, 'update']);
    Route::delete('/properties/{id}', [AdminPropertyApiController::class, 'destroy']);
});