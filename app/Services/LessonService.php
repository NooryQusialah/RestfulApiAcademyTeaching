<?php

namespace App\Services;

use App\Interfaces\LessonInterface;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Collection;

class LessonService
{
    protected LessonInterface $lessonRepository;

    public function __construct(LessonInterface $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    public function getLessonsByCourseId(int $courseId): Collection
    {
        return $this->lessonRepository->getLessonsByCourseId($courseId);
    }

    public function getLessonById(int $id): ?Lesson
    {
        return $this->lessonRepository->getLessonById($id);
    }

    public function createLesson(array $data): Lesson
    {
        return $this->lessonRepository->createLesson($data);
    }

    public function updateLesson(int $id, array $data): ?Lesson
    {
        return $this->lessonRepository->updateLesson($id, $data);
    }

    public function deleteLesson(int $id): bool
    {
        return $this->lessonRepository->deleteLesson($id);
    }
}
