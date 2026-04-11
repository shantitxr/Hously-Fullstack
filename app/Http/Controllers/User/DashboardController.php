<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalProperties = $user->properties()->count();
        $totalWishlist   = $user->wishlist()->count();

        $receivedInquiries = Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id));
        $totalInquiries    = $receivedInquiries->count();
        $newInquiries      = Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id))
                                    ->where('is_read', false)->count();

        $recentInquiries  = Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id))
            ->with(['sender', 'property'])
            ->latest()->take(3)->get();

        $recentProperties = $user->properties()->with('category')->latest()->take(3)->get();

        return view('user.dashboard', compact(
            'totalProperties', 'totalWishlist',
            'totalInquiries', 'newInquiries',
            'recentInquiries', 'recentProperties'
        ));
    }
}