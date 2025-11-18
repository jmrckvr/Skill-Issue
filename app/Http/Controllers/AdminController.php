<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = \App\Models\User::count();
        $totalJobs = \App\Models\Job::count();
        $publishedJobs = \App\Models\Job::where('status', 'published')->count();
        $totalApplications = \App\Models\JobApplication::count();
        $totalCompanies = \App\Models\Company::count();

        $recentJobs = \App\Models\Job::with('company')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        $recentUsers = \App\Models\User::orderByDesc('created_at')->take(10)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalJobs',
            'publishedJobs',
            'totalApplications',
            'totalCompanies',
            'recentJobs',
            'recentUsers'
        ));
    }

    public function users(Request $request)
    {
        $query = \App\Models\User::query();

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function jobs(Request $request)
    {
        $query = \App\Models\Job::with('company');

        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $jobs = $query->orderByDesc('created_at')->paginate(15);

        return view('admin.jobs', compact('jobs'));
    }

    public function restoreJob(\App\Models\Job $job)
    {
        // Check if job is soft deleted
        if (!$job->trashed()) {
            return back()->with('error', 'Job is not deleted.');
        }

        $job->restore();

        return back()->with('success', 'Job restored successfully!');
    }

    public function deleteJob(\App\Models\Job $job)
    {
        $job->forceDelete();

        return back()->with('success', 'Job permanently deleted!');
    }

    public function deactivateUser(\App\Models\User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot deactivate yourself.');
        }

        $user->update(['is_active' => false]);

        return back()->with('success', 'User deactivated.');
    }

    public function activateUser(\App\Models\User $user)
    {
        $user->update(['is_active' => true]);

        return back()->with('success', 'User activated.');
    }

    public function categories()
    {
        $categories = \App\Models\Category::withCount('jobs')->paginate(15);

        return view('admin.categories', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.category-form');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories',
            'icon' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        \App\Models\Category::create($validated);

        return redirect()->route('admin.categories')->with('success', 'Category created!');
    }

    public function editCategory(\App\Models\Category $category)
    {
        return view('admin.category-form', compact('category'));
    }

    public function updateCategory(Request $request, \App\Models\Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
            'icon' => 'required|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories')->with('success', 'Category updated!');
    }

    public function deleteCategory(\App\Models\Category $category)
    {
        if ($category->jobs()->count() > 0) {
            return back()->with('error', 'Cannot delete category with jobs. Please reassign jobs first.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted!');
    }
}
