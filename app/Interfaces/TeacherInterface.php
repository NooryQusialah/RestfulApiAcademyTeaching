<?php

namespace App\Interfaces;

interface TeacherInterface
{
    public function getAllTeachers();

    public function getTeacherById($id);

    public function createTeacher(array $data);

    public function updateTeacher($id, array $data);

    public function deleteTeacher($id);

    public function getTeacherCourses($id);
}
