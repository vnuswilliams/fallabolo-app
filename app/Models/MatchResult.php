<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MatchResult extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'job_offer_id', 'candidate_profile_id', 'passed_blocking',
        'score_skills', 'score_experience', 'score_education',
        'score_availability', 'score_location', 'score_salary',
        'score_principal', 'assets_matched', 'extra_skills',
        'is_stale', 'calculated_at'
    ];

    protected $casts = [
        'passed_blocking' => 'boolean',
        'assets_matched' => 'json',
        'extra_skills' => 'json',
        'is_stale' => 'boolean',
        'calculated_at' => 'datetime',
    ];

    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class);
    }

    public function candidateProfile(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class);
    }

    public function application(): HasOne
    {
        return $this->hasOne(Application::class);
    }
}
