<?php

namespace App\Repositories;

use App\Interfaces\LessonInterface;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;

class LessonRepository implements LessonInterface
{
    public function getLessonsByCourseId(int $courseId): Collection
    {
        return Lesson::where('course_id', $courseId)->orderBy('order')->get();
    }

    public function getLessonById(int $id): ?Lesson
    {
        return Lesson::find($id);
    }

    public function createLesson(array $data): Lesson
    {
        return Lesson::create($data);
    }

    public function updateLesson(int $id, array $data): ?Lesson
    {
        $lesson = Lesson::find($id);
        if (! $lesson) {
            return null;
        }
        $lesson->update($data);

        return $lesson;
    }

    public function deleteLesson(int $id): bool
    {
        $lesson = Lesson::find($id);
        if (! $lesson) {
            return false;
        }

        return $lesson->delete();
    }
}
