<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('employer.dashboard');
    }
}