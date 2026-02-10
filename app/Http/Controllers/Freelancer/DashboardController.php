<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('freelancer.dashboard');
    }
}