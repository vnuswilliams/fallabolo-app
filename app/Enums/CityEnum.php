<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum CityEnum: string
{
    use EnumTrait;

    case DOUALA = 'Douala';
    case YAOUNDE = 'Yaoundé';
    case AUTRE = 'Autre';

    public function label(): string
    {
        return $this->value;
    }
}
