<?php
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
 
class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withCount('properties')
            ->when($request->search, fn($q) => $q->where('name', 'like', '%'.$request->search.'%')
                                                  ->orWhere('email', 'like', '%'.$request->search.'%'))
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->when($request->status !== null && $request->status !== '', fn($q) => $q->where('is_active', $request->status))
            ->latest()
            ->paginate(15);
 
        return view('admin.admin-users', [
            'users'          => $users,
            'totalUsers'     => User::count(),
            'suspendedUsers' => User::where('is_active', false)->count(),
        ]);
    }
 
    public function update(Request $request, User $user)
    {
        // Prevent admin from changing their own role/status
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot modify your own account.');
        }
 
        $request->validate([
            'role'      => 'required|in:user,admin',
            'is_active' => 'required|boolean',
        ]);
 
        $user->update([
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ]);
 
        return back()->with('success', 'User updated.');
    }
 
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
?>