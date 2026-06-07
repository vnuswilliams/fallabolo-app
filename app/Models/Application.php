<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Enums\ApplicationStatusEnum;

class Application extends Model
{
    protected $fillable = ['match_result_id', 'status', 'applied_at'];

    protected $casts = [
        'status' => ApplicationStatusEnum::class,
        'applied_at' => 'datetime',
    ];

    public function matchResult(): BelongsTo
    {
        return $this->belongsTo(MatchResult::class);
    }
}
