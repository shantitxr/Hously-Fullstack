<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('user.dashboard', [
            'totalProperties'  => $user->properties()->count(),
            'totalWishlist'    => $user->wishlist()->count(),
            'totalInquiries'   => \App\Models\Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id))->count(),
            'newInquiries'     => \App\Models\Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id))->where('is_read', false)->count(),
            'recentInquiries'  => \App\Models\Inquiry::whereHas('property', fn($q) => $q->where('user_id', $user->id))->latest()->take(3)->get(),
            'recentProperties' => $user->properties()->with('images')->latest()->take(3)->get(),
        ]);
    }
}
?>