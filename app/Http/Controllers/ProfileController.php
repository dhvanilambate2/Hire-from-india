<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Show edit profile form
    public function edit()
    {
        $user = Auth::user();
        $layout = $this->getLayout();

        return view('profile.edit', compact('user', 'layout'));
    }

    // Update profile info
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'bio'   => 'nullable|string|max:1000',
        ]);

        $emailChanged = $user->email !== $request->email;

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio'   => $request->bio,
        ]);

        // If email changed, require re-verification
        if ($emailChanged) {
            $user->update(['email_verified_at' => null]);
            $user->sendEmailVerificationNotification();

            return back()->with('success', 'Profile updated! Please verify your new email address.');
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('password_success', 'Password changed successfully.');
    }

    // Delete account
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'delete_password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->delete_password, $user->password)) {
            return back()->withErrors(['delete_password' => 'Password is incorrect.']);
        }

        // Don't allow last admin to delete themselves
        if ($user->isAdmin()) {
            $adminCount = \App\Models\User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Cannot delete the last admin account.');
            }
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Your account has been deleted.');
    }

    // Get layout based on role
    private function getLayout()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin'      => 'layouts.admin',
            'freelancer' => 'layouts.dashboard',
            'employer'   => 'layouts.dashboard',
            default      => 'layouts.app',
        };
    }
}
