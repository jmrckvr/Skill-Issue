<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Show the company edit form
     */
    public function edit(Company $company)
    {
        // Verify the company belongs to the current user
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

        return view('employer.company-edit', compact('company'));
    }

    /**
     * Update company information including logo upload
     */
    public function update(Request $request, Company $company)
    {
        // Verify the company belongs to the current user
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'website' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'employee_count' => 'nullable|integer|min:0',
            'industry' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($company->logo_path && Storage::disk('public')->exists($company->logo_path)) {
                Storage::disk('public')->delete($company->logo_path);
            }

            // Store new logo in storage/app/public/company-logos/
            $logoPath = $request->file('logo')->store('company-logos', 'public');
            $validated['logo_path'] = $logoPath;
        }

        $company->update($validated);

        return back()->with('success', 'Company profile updated successfully!');
    }

    /**
     * Delete company logo
     */
    public function deleteLogo(Company $company)
    {
        // Verify the company belongs to the current user
        if ($company->user_id !== auth()->id()) {
            abort(403);
        }

        if ($company->logo_path && Storage::disk('public')->exists($company->logo_path)) {
            Storage::disk('public')->delete($company->logo_path);
        }

        $company->update(['logo_path' => null]);

        return back()->with('success', 'Logo removed successfully!');
    }
}
