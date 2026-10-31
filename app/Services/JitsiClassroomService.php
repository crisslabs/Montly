<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RoleType;

class JitsiClassroomService
{
    public function buildRoomUrl(int $subjectId, string $sectionCode, RoleType $role): array
    {
        $domain = (string) config('montly.jitsi.domain', 'meet.jit.si');
        $prefix = (string) config('montly.jitsi.room_prefix', 'montly_');
        $slug   = sprintf('%ssubject_%d_%s', $prefix, $subjectId, strtolower($sectionCode));

        return [
            'domain'    => $domain,
            'room_name' => $slug,
            'url'       => sprintf('https://%s/%s', rtrim($domain, '/'), $slug),
            'moderator' => $role->canManageClassrooms(),
        ];
    }
}
