<?php

namespace App\Services;

use App\Interfaces\CourseInterface;
use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseService
{
    protected CourseInterface $courseRepository;

    public function __construct(CourseInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAllCourses(int $limit): LengthAwarePaginator
    {
        return $this->courseRepository->getAllCourses($limit);
    }

    public function getCourseById(int $id): ?Course
    {
        return $this->courseRepository->getCourseById($id);
    }

    public function createCourse(array $data): Course
    {
        return $this->courseRepository->createCourse($data);
    }

    public function updateCourse(int $id, array $data): Course
    {
        return $this->courseRepository->updateCourse($id, $data);
    }

    public function deleteCourse(int $id): bool
    {
        return $this->courseRepository->deleteCourse($id);
    }
}
