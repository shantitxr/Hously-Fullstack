<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserApiController extends Controller
{
    // GET /api/admin/users
    public function index(Request $request)
    {
        $users = User::withCount('properties')
            ->when($request->search, fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->role, fn($q) =>
                $q->where('role', $request->role))
            ->latest()
            ->paginate(15);

        return response()->json($users);
    }

    // PUT /api/admin/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'You cannot modify your own account.'], 403);
        }

        $request->validate([
            'role'      => 'required|in:user,admin',
            'is_active' => 'required|boolean',
        ]);

        $user->update($request->only('role', 'is_active'));

        return response()->json($user->fresh());
    }

    // DELETE /api/admin/users/{id}
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'You cannot delete your own account.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted.']);
    }
}