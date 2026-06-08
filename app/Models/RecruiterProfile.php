<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class RecruiterProfile extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_sector',
        'phone',
        'city',
        'country',
        'is_managed_by',
        'is_suspended',
        'suspended_at',
    ];

    protected function casts(): array
    {
        return [
            'is_suspended' => 'boolean',
            'suspended_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::addGlobalScope('not_suspended', function (Builder $query) {
            $query->where('is_suspended', false);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function managedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'is_managed_by');
    }

    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class);
    }

    public function reports(): MorphMany
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function withSuspended(): static
    {
        return $this->withoutGlobalScope('not_suspended');
    }
}
