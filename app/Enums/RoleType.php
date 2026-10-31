<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleType: string
{
    case Administrator = 'admin';
    case Teacher       = 'teacher';
    case Student       = 'student';
    case Guardian      = 'guardian';
    case Alumni        = 'alumni';
    case Support       = 'support';

    public function accessLevel(): string
    {
        return match ($this) {
            self::Administrator => 'Full',
            self::Teacher       => 'Moderate',
            self::Student       => 'Basic',
            self::Guardian      => 'Read-Only',
            self::Alumni        => 'Historical',
            self::Support       => 'Technical',
        };
    }

    public function canManageClassrooms(): bool
    {
        return in_array($this, [self::Administrator, self::Teacher], true);
    }
}
