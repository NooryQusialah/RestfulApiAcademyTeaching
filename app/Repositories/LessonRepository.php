<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
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
        $lesson = Lesson::find($id);

        return $lesson;
    }

    public function createLesson(array $data): Lesson
    {
        return Lesson::create($data);
    }

    public function updateLesson(int $id, array $data): ?Lesson
    {
        $lesson = Lesson::find($id);
        if (! $lesson) {
            throw new NotFoundException('Lesson not found.');
        }
        $lesson->update($data);

        return $lesson;
    }

    public function deleteLesson(int $id): bool
    {
        $lesson = Lesson::find($id);
        if (! $lesson) {
            throw new NotFoundException('Lesson not found.');
        }

        return $lesson->delete();
    }
}
