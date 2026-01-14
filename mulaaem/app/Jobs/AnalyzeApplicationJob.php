<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Application;
use App\Services\AIService;
use App\Enums\ApplicationStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeApplicationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;

    public function __construct(
        public Application $application
    ) {}

    public function handle(AIService $aiService): void
    {
        Log::info("Analyzing for Application ID: {$this->application->id}");

        // Get Data
        $jobListing = $this->application->jobListing;
        
        // Extract Text
        $resumeText = $aiService->extractText($this->application->resume_path);

        if (empty($resumeText)) {
            Log::warning("Could not read PDF for App ID: {$this->application->id}");
            $this->application->update(['ai_analysis_data' => ['error' => 'PDF Unreadable']]);
            return;
        }

        // Analyze
        $analysis = $aiService->analyzeApplication(
            $resumeText,
            $jobListing->description,
            $jobListing->requirements_for_ai
        );

        // Update Application
        $this->application->update([
            'ai_score' => $analysis['score'] ?? 0,
            'ai_analysis_data' => $analysis,
            'status' => ApplicationStatus::Reviewed,
        ]);

        Log::info("Analysis Complete. Score: " . ($analysis['score'] ?? 0));
    }
}