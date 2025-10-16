<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Interfaces\CourseInterface;
use App\Models\Course;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CourseRepository implements CourseInterface
{
    public function getAllCourses(int $limit = 10): LengthAwarePaginator
    {
        return Course::paginate($limit);
    }

    public function getCourseById(int $id): ?Course
    {
        $course = Course::find($id);

        return $course;
    }

    public function createCourse(array $data): Course
    {
        return Course::create($data);
    }

    public function updateCourse(int $id, array $data): Course
    {
        $course = Course::find($id);

        if (! $course) {
            throw new NotFoundException('Course not found.');
        }
        $course->update($data);

        return $course;
    }

    public function deleteCourse(int $id): bool
    {
        $course = Course::find($id);
        if (! $course) {
            throw new NotFoundException('Course not found.');
        }

        return $course->delete();
    }
}
