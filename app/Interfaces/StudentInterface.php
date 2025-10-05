<?php

namespace App\Interfaces;

interface StudentInterface
{
    public function getAllStudents();

    public function getStudentById($id);

    public function createStudent(array $data);

    public function updateStudent($id, array $data);

    public function deleteStudent($id);

    public function getStudentCourses($id);

    public function getStudentEnrollments($id);

    public function getStudentPayments($id);

    public function getStudentQuizAttempts($id);
}
