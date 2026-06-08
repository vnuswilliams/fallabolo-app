<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum ReportReasonEnum: string
{
    use EnumTrait;

    // For JobOffer
    case FAKE_OFFER = 'fake_offer';
    case MISLEADING = 'misleading';
    case DISCRIMINATORY = 'discriminatory';
    case SUSPICIOUS_CONTACT = 'suspicious_contact';
    case DUPLICATE = 'duplicate';

    // For CandidateProfile
    case FALSE_INFO = 'false_info';
    case INAPPROPRIATE = 'inappropriate';
    case IDENTITY_THEFT = 'identity_theft';
    case SPAM = 'spam';

    public function label(): string
    {
        return match($this) {
            self::FAKE_OFFER => 'Offre fictive ou frauduleuse',
            self::MISLEADING => 'Informations trompeuses',
            self::DISCRIMINATORY => 'Offre discriminatoire',
            self::SUSPICIOUS_CONTACT => 'Coordonnées suspectes',
            self::DUPLICATE => 'Doublon',
            self::FALSE_INFO => 'Informations manifestement fausses',
            self::INAPPROPRIATE => 'Comportement inapproprié',
            self::IDENTITY_THEFT => 'Usurpation d’identité',
            self::SPAM => 'Spam',
        };
    }
}
