<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\JobType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobListing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'recruiter_id', 'title', 'slug', 'description', 
        'requirements_for_ai', 'type', 'location', 
        'salary_range', 'is_active', 'closes_at'
    ];

    protected $casts = [
        'type' => JobType::class, // Auto-cast to Enum
        'is_active' => 'boolean',
        'closes_at' => 'datetime',
    ];

    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
