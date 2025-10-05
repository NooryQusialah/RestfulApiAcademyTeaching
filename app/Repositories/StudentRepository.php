<?php

namespace App\Repositories;

use App\Interfaces\StudentInterface;
use App\Models\Student;

class StudentRepository implements StudentInterface
{
    public function getAllStudents()
    {
        return Student::with('user')->get();
    }

    public function getStudentById($id)
    {
        return Student::with('user')->findOrFail($id);
    }

    public function createStudent(array $data)
    {
        return Student::create($data);
    }

    public function updateStudent($id, array $data)
    {
        $student = Student::findOrFail($id);
        $student->update($data);
        return $student;
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        return $student->delete();
    }

    public function getStudentCourses($id)
    {
        $student = Student::with('courses')->findOrFail($id);
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
