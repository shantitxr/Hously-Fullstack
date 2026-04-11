<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
 
class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin-dashboard', [
            'totalProperties' => Property::count(),
            'totalUsers'      => User::count(),
            'totalInquiries'  => Inquiry::count(),
            'recentProperties'=> Property::with('images')->latest()->take(5)->get(),
            'recentUsers'     => User::latest()->take(5)->get(),
        ]);
    }
}
?>