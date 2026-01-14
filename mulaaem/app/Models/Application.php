<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'job_listing_id', 'user_id', 'resume_path', 
        'status', 'ai_score', 'ai_analysis_data'
    ];

    protected $casts = [
        'status' => ApplicationStatus::class, // Auto-cast to Enum
        'ai_analysis_data' => 'array',
        'ai_score' => 'integer',
    ];

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
