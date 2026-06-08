<?php

namespace App\Enums;
use App\Concerns\EnumTrait;

enum RoleEnum: string
{
    use EnumTrait;

    case RECRUITER = 'recruiter';
    case CANDIDATE = 'candidate';
    case ADMIN = 'admin';


    public function label(): string
    {
        return match($this) {
            self::RECRUITER => 'Recruteur',
            self::CANDIDATE => 'Candidat',
            self::ADMIN => 'Administrateur',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::RECRUITER => 'Je souhaite recruter les meilleurs talents',
            self::CANDIDATE => 'Je recherche les meilleures opportunités professionnelles',
            self::ADMIN => 'Gestion de la plateforme',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::RECRUITER => 'user',
            self::CANDIDATE => 'building-office',
            self::ADMIN => 'shield-check',
        };
    }

}



