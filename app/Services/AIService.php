<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use Spatie\PdfToText\Pdf;
use Illuminate\Support\Facades\Log;

class AIService
{
    public function extractText(string $storagePath): string
    {
        try {
            // Get the absolute path
            $fullPath = storage_path('app/public/' . $storagePath);

            // Get the binary path
            $binaryPath = config('services.pdf.binary');

            // extract using Spatie
            $text = Pdf::getText($fullPath, $binaryPath);

            //  limit to 10000 characters to save tokens
            return substr($text, 0, 10000); 
        } catch (\Exception $e) {
            Log::error("PDF Extraction Failed: " . $e->getMessage());
            return "";
        }
    }

    /**
     * Sends the text to OpenAI for structured analysis.
     */
    public function analyzeApplication(string $resumeText, string $jobDescription, ?string $aiInstructions): array
    {
        $systemPrompt = "You are a senior recruiter. Output strictly valid JSON.";
        
        $userPrompt = "
            Analyze this Candidate based on the Job Description.
            
            JOB DESCRIPTION:
            $jobDescription
            
            RECRUITER NOTES:
            $aiInstructions
            
            CANDIDATE RESUME TEXT:
            $resumeText
            
            OUTPUT FORMAT (JSON ONLY):
            {
                'score': (integer 0-100),
                'summary': (string, max 30 words),
                'key_skills_match': (array of strings, max 5),
                'missing_skills': (array of strings, max 3),
                'red_flags': (array of strings, or empty)
            }
        ";

        try {
            $result = OpenAI::chat()->create([
                'model' => 'gpt-4o', 
                'response_format' => ['type' => 'json_object'],
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'temperature' => 0.2, 
            ]);

            return json_decode($result->choices[0]->message->content, true);

        } catch (\Exception $e) {
            Log::error("OpenAI Analysis Failed: " . $e->getMessage());
            return [
                'score' => 0,
                'summary' => 'AI Analysis failed.',
                'key_skills_match' => [],
                'missing_skills' => [],
                'red_flags' => []
            ];
        }
    }
}