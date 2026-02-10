<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function store(Request $request)
    {
        auth()->user()->company->jobs()->create($request->all());
        return back();
    }
}
