<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;

class AdminController extends Controller
{
    public function approveJob(Job $job)
    {
        $job->update(['is_approved'=>true]);
    }

    public function blockUser(User $user)
    {
        $user->update(['is_blocked'=>true]);
    }
}
