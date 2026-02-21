<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\PortfolioLink;
use App\Models\UserSkill;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // ── Get Layout ──
    private function getLayout()
    {
        $role = Auth::user()->role;
        return match ($role) {
            'admin'      => 'layouts.admin',
            'employer'   => 'layouts.dashboard',
            'freelancer' => 'layouts.dashboard',
            default      => 'layouts.dashboard',
        };
    }

    // ── Show Profile ──
    public function edit()
    {
        $user = Auth::user();
        $layout = $this->getLayout();

        // Only load freelancer-specific relationships
        if ($user->isFreelancer()) {
            $user->load(['skills', 'workExperiences', 'educations', 'portfolioLinks']);
        }

        return view('profile.edit', compact('user', 'layout'));
    }

    // ── Update Basic Info ──
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Base validation for ALL roles
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'bio'   => 'nullable|string|max:1000',
        ];

        // Freelancer-only fields
        if ($user->isFreelancer()) {
            $rules['hourly_rate']  = 'nullable|numeric|min:0|max:9999';
            $rules['availability'] = 'nullable|in:full_time,part_time';
        }

        $request->validate($rules);

        $emailChanged = $user->email !== $request->email;

        // Base data for ALL roles
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio'   => $request->bio,
        ];

        // Freelancer-only data
        if ($user->isFreelancer()) {
            $data['hourly_rate']  = $request->hourly_rate;
            $data['availability'] = $request->availability;
        }

        $user->update($data);

        if ($emailChanged) {
            $user->update(['email_verified_at' => null]);
            $user->sendEmailVerificationNotification();
            return back()->with('success', 'Profile updated! Please verify your new email address.');
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    // ── Upload Profile Photo ──
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = Auth::user();

        // Delete old photo
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user->update(['profile_photo' => $path]);

        return response()->json([
            'success' => true,
            'url'     => asset('storage/' . $path),
            'message' => 'Profile photo uploaded successfully!',
        ]);
    }

    // ── Remove Profile Photo ──
    public function removePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile photo removed successfully!',
        ]);
    }

    // ── Upload Resume ──
    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $user = Auth::user();

        if ($user->resume) {
            Storage::disk('public')->delete($user->resume);
        }

        $path = $request->file('resume')->store('resumes', 'public');
        $user->update(['resume' => $path]);

        return back()->with('success', 'Resume uploaded successfully!');
    }

    // ── Remove Resume ──
    public function removeResume()
    {
        $user = Auth::user();

        if ($user->resume) {
            Storage::disk('public')->delete($user->resume);
            $user->update(['resume' => null]);
        }

        return back()->with('success', 'Resume removed successfully!');
    }

    // ── Skills ──
    public function addSkill(Request $request)
    {
        $request->validate([
            'skill_name' => 'required|string|max:100',
        ]);

        $user = Auth::user();

        // Check duplicate
        $exists = $user->skills()->where('skill_name', $request->skill_name)->exists();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Skill already added!',
            ], 422);
        }

        $skill = $user->skills()->create([
            'skill_name' => $request->skill_name,
        ]);

        return response()->json([
            'success' => true,
            'skill'   => $skill,
            'message' => 'Skill added successfully!',
        ]);
    }

    public function removeSkill(UserSkill $skill)
    {
        if ($skill->user_id !== Auth::id()) {
            abort(403);
        }

        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill removed successfully!',
        ]);
    }

    // ── Work Experience ──
    public function storeExperience(Request $request)
    {
        $request->validate([
            'company_name'    => 'required|string|max:255',
            'position'        => 'required|string|max:255',
            'employment_type' => 'required|in:full_time,part_time,contract,freelance,internship,temporary',
            'start_year'      => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'end_year'        => 'nullable|digits:4|integer|min:1950|max:' . date('Y'),
            'is_current'      => 'nullable|boolean',
            'description'     => 'nullable|string|max:1000',
        ]);

        Auth::user()->workExperiences()->create([
            'company_name'    => $request->company_name,
            'position'        => $request->position,
            'employment_type' => $request->employment_type,
            'start_year'      => $request->start_year,
            'end_year'        => $request->is_current ? null : $request->end_year,
            'is_current'      => $request->boolean('is_current'),
            'description'     => $request->description,
        ]);

        return back()->with('success', 'Work experience added successfully!');
    }

    public function updateExperience(Request $request, WorkExperience $experience)
    {
        if ($experience->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'company_name'    => 'required|string|max:255',
            'position'        => 'required|string|max:255',
            'employment_type' => 'required|in:full_time,part_time,contract,freelance,internship,temporary',
            'start_year'      => 'required|digits:4|integer|min:1950|max:' . date('Y'),
            'end_year'        => 'nullable|digits:4|integer|min:1950|max:' . date('Y'),
            'is_current'      => 'nullable|boolean',
            'description'     => 'nullable|string|max:1000',
        ]);

        $experience->update([
            'company_name'    => $request->company_name,
            'position'        => $request->position,
            'employment_type' => $request->employment_type,
            'start_year'      => $request->start_year,
            'end_year'        => $request->is_current ? null : $request->end_year,
            'is_current'      => $request->boolean('is_current'),
            'description'     => $request->description,
        ]);

        return back()->with('success', 'Work experience updated successfully!');
    }

    public function destroyExperience(WorkExperience $experience)
    {
        if ($experience->user_id !== Auth::id()) {
            abort(403);
        }

        $experience->delete();
        return back()->with('success', 'Work experience removed successfully!');
    }

    // ── Education ──
    public function storeEducation(Request $request)
    {
        $request->validate([
            'institution'  => 'required|string|max:255',
            'degree'       => 'required|string|max:255',
            'start_month'  => 'required|date_format:Y-m',
            'end_month'    => 'nullable|date_format:Y-m',
            'grade'        => 'nullable|string|max:50',
            'description'  => 'nullable|string|max:1000',
        ]);

        Auth::user()->educations()->create($request->only([
            'institution', 'degree', 'start_month', 'end_month', 'grade', 'description',
        ]));

        return back()->with('success', 'Education added successfully!');
    }

    public function updateEducation(Request $request, Education $education)
    {
        if ($education->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'institution'  => 'required|string|max:255',
            'degree'       => 'required|string|max:255',
            'start_month'  => 'required|date_format:Y-m',
            'end_month'    => 'nullable|date_format:Y-m',
            'grade'        => 'nullable|string|max:50',
            'description'  => 'nullable|string|max:1000',
        ]);

        $education->update($request->only([
            'institution', 'degree', 'start_month', 'end_month', 'grade', 'description',
        ]));

        return back()->with('success', 'Education updated successfully!');
    }

    public function destroyEducation(Education $education)
    {
        if ($education->user_id !== Auth::id()) {
            abort(403);
        }

        $education->delete();
        return back()->with('success', 'Education removed successfully!');
    }

    // ── Portfolio Links ──
    public function storePortfolio(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url'   => 'required|url|max:500',
        ]);

        Auth::user()->portfolioLinks()->create([
            'title' => $request->title,
            'url'   => $request->url,
        ]);

        return back()->with('success', 'Portfolio link added successfully!');
    }

    public function destroyPortfolio(PortfolioLink $portfolio)
    {
        if ($portfolio->user_id !== Auth::id()) {
            abort(403);
        }

        $portfolio->delete();
        return back()->with('success', 'Portfolio link removed successfully!');
    }

    // ── Submit for Review ──
    public function submitForReview()
    {
        $user = Auth::user();

        if ($user->profile_completeness < 60) {
            return back()->with('error', 'Please complete at least 60% of your profile before submitting for review.');
        }

        $user->update(['profile_status' => 'under_review']);

        return back()->with('success', 'Profile submitted for review successfully!');
    }

    // ── Password ──
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('password_success', 'Password changed successfully.');
    }

    // ── Delete Account ──
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'delete_password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->delete_password, $user->password)) {
            return back()->withErrors(['delete_password' => 'Password is incorrect.']);
        }

        // Clean up files
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }
        if ($user->resume) {
            Storage::disk('public')->delete($user->resume);
        }

        Auth::logout();
        $user->delete();

        return redirect()->route('login')->with('success', 'Account deleted successfully.');
    }
}
