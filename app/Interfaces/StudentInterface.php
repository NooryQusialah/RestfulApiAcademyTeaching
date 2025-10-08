<?php

namespace App\Interfaces;

interface StudentInterface
{
    public function getAllStudents();

    public function getStudentById($id);

    public function createStudent(array $data);

    public function updateStudent($id, array $data);

    public function deleteStudent($id);

    public function assignCourseToStudent($studentId, $courseId);

    public function enrollmentInCourse(array $data);

    public function removeCourseFromStudent($studentId, $courseId);

    public function removeEnrollmentFromStudent($studentId, $courseId);

    public function getStudentCourses($id);

    public function getStudentCourse($courseId);

    public function getStudentEnrollments($id);

    public function getStudentPayments($id);

    public function getStudentQuizAttempts($id);
}
