<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // Show all freelancers
    public function freelancers(Request $request)
    {
        $query = User::freelancers();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $freelancers = $query->latest()->paginate(10);

        return view('admin.users.freelancers', compact('freelancers'));
    }

    // Show all employers
    public function employers(Request $request)
    {
        $query = User::employers();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $employers = $query->latest()->paginate(10);

        return view('admin.users.employers', compact('employers'));
    }

    // Show all users (both freelancers & employers)
    public function allUsers(Request $request)
    {
        $query = User::whereIn('role', ['freelancer', 'employer']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.all', compact('users'));
    }

    // View single user
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // Toggle user active status
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User {$user->name} has been {$status}.");
    }

    // Delete user
    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin from here.');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}