<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum PermissionEnum: string
{
    use EnumTrait;

    // Recruiter Permissions
    case POST_JOB = 'post_job';
    case VIEW_CANDIDATES = 'view_candidates';
    case MANAGE_OFFERS = 'manage_offers';

    // Candidate Permissions
    case APPLY_JOB = 'apply_job';
    case UPDATE_PROFILE = 'update_profile';
    case VIEW_MATCHES = 'view_matches';

    public function label(): string
    {
        return match($this) {
            self::POST_JOB => 'Publier une offre',
            self::VIEW_CANDIDATES => 'Voir les candidats',
            self::MANAGE_OFFERS => 'Gérer les offres',
            self::APPLY_JOB => 'Postuler à une offre',
            self::UPDATE_PROFILE => 'Mettre à jour le profil',
            self::VIEW_MATCHES => 'Voir les scores de matching',
        };
    }
}
