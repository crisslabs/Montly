<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleSlot extends Model
{
    protected $fillable = [
        'school_year_id',
        'grade_id',
        'section_id',
        'classroom_id',
        'subject_id',
        'teacher_id',
        'day_of_week',
        'starts_at',
        'ends_at',
    ];

    /**
     * Checks whether another slot overlaps for the same teacher, classroom, or section.
     */
    public static function hasConflict(
        int $schoolYearId,
        int $dayOfWeek,
        string $startsAt,
        string $endsAt,
        int $teacherId,
        int $classroomId,
        int $sectionId,
        ?int $ignoreId = null
    ): bool {
        return static::query()
            ->where('school_year_id', $schoolYearId)
            ->where('day_of_week', $dayOfWeek)
            ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
            ->where('starts_at', '<', $endsAt)
            ->where('ends_at', '>', $startsAt)
            ->where(function ($q) use ($teacherId, $classroomId, $sectionId) {
                $q->where('teacher_id', $teacherId)
                  ->orWhere('classroom_id', $classroomId)
                  ->orWhere('section_id', $sectionId);
            })
            ->exists();
    }
}
