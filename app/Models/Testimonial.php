<?php

namespace App\Models;

use App\Enums\TestimonialStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'rating',
        'status',
        'author_name',
        'author_role',
        'author_company',
        'author_color',
        'author_badge',
    ];

    protected $casts = [
        'status' => TestimonialStatusEnum::class,
        'rating' => 'integer',
    ];

    /**
     * Get the user that owns the testimonial.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
