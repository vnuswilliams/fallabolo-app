<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ReportStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
     protected $fillable = [
        'user_id',
        'email',
        'question',
        'answer',
        'status',
        'reviewed_by',
        'reviewed_at',
    ];


    protected function casts():array
    {
        return [
            'status' => ReportStatusEnum::class,
            'reviewed_at' => 'datetime',
        ];
    }

     public function questionner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    protected static function booted()
    {
         static::creating(function ($faq) {
                $faq->status ??= ReportStatusEnum::PENDING;
        });
    }
}
