<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function candidateSkills(): HasMany
    {
        return $this->hasMany(CandidateSkill::class);
    }

    public function jobRequiredSkills(): HasMany
    {
        return $this->hasMany(JobRequiredSkill::class);
    }
}
