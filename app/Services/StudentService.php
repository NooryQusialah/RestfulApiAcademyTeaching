<?php

namespace App\Services;

use App\Repositories\StudentRepository;

class StudentService
{
    protected $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function getAllStudents()
    {
        return $this->studentRepository->getAllStudents();
    }

    public function getStudentById($id)
    {
        return $this->studentRepository->getStudentById($id);
    }

    public function createStudent(array $data)
    {
        return $this->studentRepository->createStudent($data);
    }

    public function updateStudent($id, array $data)
    {
        return $this->studentRepository->updateStudent($id, $data);
    }

    public function deleteStudent($id)
    {
        return $this->studentRepository->deleteStudent($id);
    }

    public function assignCourseToStudent($studentId, $courseId)
    {
        return $this->studentRepository->assignCourseToStudent($studentId, $courseId);
    }

    public function enrollmentInCourse(array $data)
    {
        return $this->studentRepository->enrollmentInCourse($data);
    }

    public function removeEnrollmentFromStudent($studentId, $courseId)
    {
        return $this->studentRepository->removeEnrollmentFromStudent($studentId, $courseId);
    }

    public function removeCourseFromStudent($studentId, $courseId)
    {
        return $this->studentRepository->removeCourseFromStudent($studentId, $courseId);
    }

    public function getStudentCourses($id)
    {
        return $this->studentRepository->getStudentCourses($id);
    }

    public function getStudentCourse($courseId)
    {
        return $this->studentRepository->getStudentCourse($courseId);
    }

    public function getStudentEnrollments($id)
    {
        return $this->studentRepository->getStudentEnrollments($id);
    }

    public function getStudentPayments($id)
    {
        return $this->studentRepository->getStudentPayments($id);
    }

    public function getStudentQuizAttempts($id)
    {
        return $this->studentRepository->getStudentQuizAttempts($id);
    }
}
