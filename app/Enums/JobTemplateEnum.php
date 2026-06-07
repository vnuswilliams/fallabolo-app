<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum JobTemplateEnum: string
{
    use EnumTrait;

    case MANOEUVRE = 'manoeuvre';
    case TECHNICIEN = 'technicien';
    case AGENT = 'agent';
    case CADRE = 'cadre';
    case DIRIGEANT = 'dirigeant';

    public function label(): string
    {
        return match($this) {
            self::MANOEUVRE => 'Manœuvre & Ouvrier',
            self::TECHNICIEN => 'Employé & Technicien',
            self::AGENT => 'Agent de maîtrise',
            self::CADRE => 'Cadre',
            self::DIRIGEANT => 'Cadre dirigeant',
        };
    }
}
