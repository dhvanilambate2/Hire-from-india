<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Public profile view (anyone can see)
    public function show($id)
    {
        $freelancer = User::where('id', $id)
            ->where('role', 'freelancer')
            ->where('is_active', true)
            ->with([
                'skills',
                'workExperiences',
                'educations',
                'portfolioLinks',
            ])
            ->firstOrFail();

        return view('freelancer.profile.show', compact('freelancer'));
    }

    // Get shareable link (for logged-in freelancer)
    public function myProfile()
    {
        $freelancer = Auth::user();
        $freelancer->load([
            'skills',
            'workExperiences',
            'educations',
            'portfolioLinks',
        ]);

        return view('freelancer.profile.show', compact('freelancer'));
    }

    // Copy link page
    public function shareLink()
    {
        $user = Auth::user();
        $profileUrl = route('freelancer.profile.public', $user->id);

        return view('freelancer.profile.share', compact('profileUrl', 'user'));
    }
}
