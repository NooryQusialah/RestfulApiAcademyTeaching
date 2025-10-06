<?php

namespace App\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Course;

interface CourseInterface
{
    public function getAllCourses(int $limit): LengthAwarePaginator;
    public function getCourseById(int $id): ?Course;
    public function createCourse(array $data): Course;
    public function updateCourse(int $id, array $data): Course;
    public function deleteCourse(int $id): bool;
}
