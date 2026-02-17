<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    // Show company profile (create or edit)
    public function index()
    {
        $company = Auth::user()->company;
        return view('employer.company.index', compact('company'));
    }

    // Store new company
    public function store(Request $request)
    {
        $request->validate([
            'company_name'    => 'required|string|max:255',
            'company_logo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'company_email'   => 'nullable|email|max:255',
            'company_phone'   => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
        ]);

        $data = [
            'employer_id'     => Auth::id(),
            'company_name'    => $request->company_name,
            'company_email'   => $request->company_email,
            'company_phone'   => $request->company_phone,
            'company_address' => $request->company_address,
        ];

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $request->file('company_logo')
                ->store('company-logos', 'public');
        }

        Auth::user()->company()->create($data);

        return redirect()->route('employer.company.index')
            ->with('success', 'Company profile created successfully!');
    }

    // Update company
    public function update(Request $request)
    {
        $company = Auth::user()->company;

        if (!$company) {
            return redirect()->route('employer.company.index')
                ->with('error', 'Please create your company profile first.');
        }

        $request->validate([
            'company_name'    => 'required|string|max:255',
            'company_logo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'company_email'   => 'nullable|email|max:255',
            'company_phone'   => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
        ]);

        $data = [
            'company_name'    => $request->company_name,
            'company_email'   => $request->company_email,
            'company_phone'   => $request->company_phone,
            'company_address' => $request->company_address,
        ];

        // Handle logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo
            if ($company->company_logo) {
                Storage::disk('public')->delete($company->company_logo);
            }
            $data['company_logo'] = $request->file('company_logo')
                ->store('company-logos', 'public');
        }

        $company->update($data);

        return redirect()->route('employer.company.index')
            ->with('success', 'Company profile updated successfully!');
    }

    // Remove logo (AJAX call from Dropzone)
    public function removeLogo()
    {
        $company = Auth::user()->company;

        if ($company && $company->company_logo) {
            Storage::disk('public')->delete($company->company_logo);
            $company->update(['company_logo' => null]);
        }

        return response()->json(['success' => true, 'message' => 'Logo removed successfully!']);
    }

    // Upload logo via Dropzone (AJAX)
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'company_logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $company = Auth::user()->company;

        // Delete old logo if exists
        if ($company && $company->company_logo) {
            Storage::disk('public')->delete($company->company_logo);
        }

        $path = $request->file('company_logo')
            ->store('company-logos', 'public');

        if ($company) {
            $company->update(['company_logo' => $path]);
        }

        return response()->json([
            'success' => true,
            'path'    => $path,
            'url'     => asset('storage/' . $path),
            'message' => 'Logo uploaded successfully!',
        ]);
    }
}
