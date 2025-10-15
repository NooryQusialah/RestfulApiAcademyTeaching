<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\StudentInterface;
use App\Models\Enrollment;
use App\Models\Student;

class StudentRepository implements StudentInterface
{
    public function getAllStudents()
    {
        return Student::with('user')->get();
    }

    public function getStudentById($id)
    {
        return Student::with('user')->where('user_id', $id)->first();
    }

    public function createStudent(array $data)
    {
        return Student::create($data);
    }

    public function updateStudent($id, array $data)
    {
        $student = Student::where('user_id', $id)->first();
        $student->update($data);

        return $student;
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);

        return $student->delete();
    }

    public function assignCourseToStudent($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        if ($student->courses()->where('course_id', $courseId)->exists()) {
            return ResponseHelper::error('This course is already assigned to the student.', 400);
        }
        $student->courses()->attach($courseId);
    }

    public function enrollmentInCourse(array $data)
    {
        return Enrollment::create($data);
    }

    public function removeCourseFromStudent($studentId, $courseId)
    {
        $student = Student::findOrFail($studentId);
        if (! $student->courses()->where('course_id', $courseId)->exists()) {
            return ResponseHelper::error('Student is not enrolled in this course.', 400);
        }

        // Detach the course
        $student->courses()->detach($courseId);
    }

    public function removeEnrollmentFromStudent($studentId, $courseId)
    {
        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->first();

        if (! $enrollment) {
            return ResponseHelper::error('Enrollment not found for this student and course.', 400);
        }

        $enrollment->delete();
    }

    public function getStudentCourses($id)
    {
        $student = Student::with('courses')->findOrFail($id);

        return $student;
    }

    public function getStudentCourse($courseId)
    {
        $id = auth()->user()->student->user_id;
        // Assuming you want to get a specific course for a student
        $student = Student::whereHas('courses', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })->where('user_id', $id)->firstOrFail();

        return $student->courses;

    }

    public function getStudentEnrollments($id)
    {
        $student = Student::with('enrollments')->findOrFail($id);

        return $student->enrollments;
    }

    public function getStudentPayments($id)
    {
        $student = Student::with('payments')->findOrFail($id);

        return $student->payments;
    }

    public function getStudentQuizAttempts($id)
    {
        $student = Student::with('quizAttempts')->findOrFail($id);

        return $student->quizAttempts;
    }
}
