<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Enums\AssetCategoryEnum;

class Asset extends Model
{
    protected $fillable = ['name', 'category', 'is_active'];

    protected $casts = [
        'category' => AssetCategoryEnum::class,
        'is_active' => 'boolean',
    ];
}
