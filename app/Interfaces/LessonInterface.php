<?php

namespace App\Interfaces;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;

interface LessonInterface
{
    public function getLessonsByCourseId(int $courseId): Collection;

    public function getLessonById(int $id): ?Lesson;

    public function createLesson(array $data): Lesson;

    public function updateLesson(int $id, array $data): ?Lesson;

    public function deleteLesson(int $id): bool;
}
