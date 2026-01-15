<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use Illuminate\View\View;

class PublicJobController extends Controller
{
    public function index(): View
    {
        $jobs = JobListing::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('closes_at')->orWhere('closes_at', '>', now());
            })
            ->latest()
            ->paginate(9);

        return view('jobs.index', compact('jobs'));
    }

    public function show(JobListing $job): View
    {
        abort_if(! $job->is_active, 404);
        return view('jobs.show', compact('job'));
    }
}