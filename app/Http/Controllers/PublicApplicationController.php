<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\Application;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Jobs\AnalyzeApplicationJob;
use App\Enums\UserRole;
use App\Enums\ApplicationStatus;


class PublicApplicationController extends Controller
{
    public function store(Request $request, JobListing $job)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'resume' => 'required|file|mimes:pdf|max:2048',
        ]);

        // 1. Find or Create Candidate User
        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make(Str::random(16)), // Dummy password
            ]
        );

        if ($user->wasRecentlyCreated) {
            $user->assignRole(UserRole::Candidate->value);
        }

        // 2. Prevent Duplicate Applications
        if (Application::where('user_id', $user->id)->where('job_listing_id', $job->id)->exists()) {
            return back()->with('error', 'You already applied for this position.');
        }

        // 3. Upload File
        $path = $request->file('resume')->store('resumes', 'public');

        // 4. Create Application
        $app = Application::create([
            'job_listing_id' => $job->id,
            'user_id'        => $user->id,
            'resume_path'    => $path,
            'status'         => ApplicationStatus::Pending,
        ]);

        // 5. Trigger AI Analysis
        AnalyzeApplicationJob::dispatch($app);

        return back()->with('success', 'Application received! Our AI is reviewing your profile.');
    }
}