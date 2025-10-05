<?php

namespace App\Services;

use App\Interfaces\TeacherInterface;
use App\Repositories\TeacherRepository;

class TeacherService
{
    protected $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function getAllTeachers()
    {
        return $this->teacherRepository->getAllTeachers();
    }

    public function getTeacherById($id)
    {
        return $this->teacherRepository->getTeacherById($id);
    }

    public function createTeacher(array $data)
    {
        return $this->teacherRepository->createTeacher($data);
    }

    public function updateTeacher($id, array $data)
    {
        return $this->teacherRepository->updateTeacher($id, $data);
    }

    public function deleteTeacher($id)
    {
        return $this->teacherRepository->deleteTeacher($id);
    }

    public function getTeacherCourses($id)
    {
        return $this->teacherRepository->getTeacherCourses($id);
    }
}
