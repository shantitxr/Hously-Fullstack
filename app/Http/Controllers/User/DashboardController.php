<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('user.dashboard', [
            'totalProperties'  => $user->properties()->count(),
            'totalWishlist'    => $user->wishlist()->count(),
            'totalInquiries'   => Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id))->count(),
            'newInquiries'     => Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id))->where('is_read', false)->count(),
            'recentInquiries'  => Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id))
                                    ->with(['property', 'sender'])->latest()->take(3)->get(),
            'recentProperties' => $user->properties()->with('category')->latest()->take(3)->get(),
        ]);
    }
}
