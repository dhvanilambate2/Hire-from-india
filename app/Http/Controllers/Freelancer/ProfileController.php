<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create()
    {
        return view('freelancer.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'skills' => 'required',
            'hourly_rate' => 'required|integer',
            'availability' => 'required'
        ]);

        auth()->user()->profile()->create($request->all());

        return redirect()->route('dashboard');
    }
}
