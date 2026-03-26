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
        $query = User::freelancers()->withCount(['skills', 'workExperiences', 'educations']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('profile_status')) {
            $query->where('profile_status', $request->profile_status);
        }

        $freelancers = $query->latest()->paginate(10);

        return view('admin.users.freelancers', compact('freelancers'));
    }

    // Show all employers
    public function employers(Request $request)
    {
        $query = User::employers()->with('company')->withCount(['jobPosts']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('profile_status')) {
            $query->where('profile_status', $request->profile_status);
        }

        $employers = $query->latest()->paginate(10);

        return view('admin.users.employers', compact('employers'));
    }

    // Show all users (both freelancers & employers)
    public function allUsers(Request $request)
    {
        $query = User::whereIn('role', ['freelancer', 'employer'])
            ->with('company')
            ->withCount(['skills', 'workExperiences', 'educations']);

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

        if ($request->filled('profile_status')) {
            $query->where('profile_status', $request->profile_status);
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.all', compact('users'));
    }

    // View single user
    public function show(User $user)
    {
        $user->load([
            'skills',
            'workExperiences',
            'educations',
            'portfolioLinks',
            'company',
            'jobPosts' => function ($q) {
                $q->latest()->limit(5);
            },
            'jobApplications' => function ($q) {
                $q->with('jobPost')->latest()->limit(5);
            },
        ]);

        return view('admin.users.show', compact('user'));
    }

    // Toggle user active status
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User {$user->name} has been {$status}.");
    }

    // ── NEW: Update Profile Status ──
    public function updateProfileStatus(Request $request, User $user)
    {
        $request->validate([
            'profile_status' => 'required|in:draft,under_review,verified,rejected,suspended',
            'status_reason'  => 'nullable|string|max:500',
        ]);

        $user->update([
            'profile_status' => $request->profile_status,
        ]);

        $statusLabel = $user->profile_status_label;

        return back()->with('success', "Profile status changed to '{$statusLabel}' for {$user->name}.");
    }

    // ── NEW: Bulk Update Profile Status ──
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'user_ids'       => 'required|array',
            'user_ids.*'     => 'exists:users,id',
            'profile_status' => 'required|in:draft,under_review,verified,rejected,suspended',
        ]);

        User::whereIn('id', $request->user_ids)
            ->update(['profile_status' => $request->profile_status]);

        $count = count($request->user_ids);

        return back()->with('success', "Profile status updated for {$count} users.");
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
