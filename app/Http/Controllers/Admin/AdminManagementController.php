<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminManagementController extends Controller
{
    // Show all admins
    public function index(Request $request)
    {
        $query = User::admins();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $admins = $query->latest()->paginate(10);

        return view('admin.admins.index', compact('admins'));
    }

    // Show create admin form
    public function create()
    {
        return view('admin.admins.create');
    }

    // Store new admin
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
        ]);

        $admin = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'role'              => User::ROLE_ADMIN,
            'phone'             => $request->phone,
            'email_verified_at' => now(), // Auto-verify admin
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', "Admin '{$admin->name}' created successfully.");
    }

    // Delete admin
    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        if (!$admin->isAdmin()) {
            return back()->with('error', 'This user is not an admin.');
        }

        $admin->delete();

        return back()->with('success', 'Admin deleted successfully.');
    }
}