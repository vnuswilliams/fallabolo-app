<?php

namespace App\Enums;

use App\Concerns\EnumTrait;

enum JobStatusEnum: string
{
    use EnumTrait;

    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case CLOSED = 'closed';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'Brouillon',
            self::PUBLISHED => 'Publiée',
            self::CLOSED => 'Clôturée',
            self::ARCHIVED => 'Archivée',
        };
    }
}
