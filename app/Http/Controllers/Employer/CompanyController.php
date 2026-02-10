<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function create()
    {
        return view('employer.company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'description'=>'required'
        ]);

        auth()->user()->company()->create($request->all());
        return redirect()->route('dashboard');
    }
}
