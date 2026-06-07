<?php

namespace App\Enums;
use App\Concerns\EnumTrait;

enum RoleEnum: string
{
    use EnumTrait;

    case RECRUITER = 'recruiter';
    case CANDIDATE = 'candidate';


    public function label(): string
    {
        return match($this) {
            self::RECRUITER => 'Recruteur',
            self::CANDIDATE => 'Candidat',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::RECRUITER => 'Je souhaite recruter les meilleurs talents',
            self::CANDIDATE => 'Je recherche les meilleures opportunités professionnelles',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::RECRUITER => 'user',
            self::CANDIDATE => 'building-office',
        };
    }

}



