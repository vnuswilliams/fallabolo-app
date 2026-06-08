<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum RegionEnum: string
{
    use EnumTrait;

    case ADAMAOUA = 'Adamaoua';
    case CENTRE = 'Centre';
    case EST = 'Est';
    case EXTREME_NORD = 'Extrême-Nord';
    case LITTORAL = 'Littoral';
    case NORD = 'Nord';
    case NORD_OUEST = 'Nord-Ouest';
    case OUEST = 'Ouest';
    case SUD = 'Sud';
    case SUD_OUEST = 'Sud-Ouest';

    public function label(): string
    {
        return $this->value;
    }
}
