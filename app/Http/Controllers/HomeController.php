<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $latestJobs = Job::published()->latest('published_at')->take(12)->get();
        $totalJobs = Job::published()->count();
        $totalCompanies = \App\Models\Company::count();

        return view('home', compact('categories', 'latestJobs', 'totalJobs', 'totalCompanies'));
    }

    public function search(Request $request)
    {
        $keyword = $request->query('keyword', '');
        $location = $request->query('location', '');
        $categoryId = $request->query('category', null);
        $jobType = $request->query('job_type', null);
        $experienceLevel = $request->query('experience', null);
        $page = $request->query('page', 1);
        $perPage = 15;

        $query = Job::published();

        if ($keyword) {
            $query->byKeyword($keyword);
        }

        if ($location) {
            $query->byLocation($location);
        }

        if ($categoryId) {
            $query->byCategory($categoryId);
        }

        if ($jobType) {
            $query->where('job_type', $jobType);
        }

        if ($experienceLevel) {
            $query->where('experience_level', $experienceLevel);
        }

        $jobs = $query->paginate($perPage);
        $categories = Category::all();

        return view('jobs.search', compact('jobs', 'categories', 'keyword', 'location', 'categoryId', 'jobType', 'experienceLevel'));
    }
}
