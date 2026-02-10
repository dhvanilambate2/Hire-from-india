<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FreelancerProfile;

class FreelancerProfileController extends Controller
{
    public function edit()
    {
        $profile = auth()->user()->freelancerProfile;

        return view('freelancer.profile', compact('profile'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'skills' => 'required|string',
            'hourly_rate' => 'required|integer',
            'availability' => 'required|in:part-time,full-time',
        ]);

        FreelancerProfile::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'skills' => $request->skills,
                'hourly_rate' => $request->hourly_rate,
                'availability' => $request->availability,
            ]
        );

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
