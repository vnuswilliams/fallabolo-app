<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum LanguageProfileEnum: string
{
    use EnumTrait;

    case FRANCOPHONE = 'francophone';
    case ANGLOPHONE = 'anglophone';
    case BILINGUE = 'bilingue';

    public function label(): string
    {
        return match($this) {
            self::FRANCOPHONE => 'Francophone',
            self::ANGLOPHONE => 'Anglophone',
            self::BILINGUE => 'Bilingue',
        };
    }
}
