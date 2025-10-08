<?php

namespace App\Repositories;

use App\Interfaces\TeacherInterface;
use App\Models\Teacher;

class TeacherRepository implements TeacherInterface
{
    public function getAllTeachers()
    {
        return Teacher::with('user')->get();
    }

    public function getTeacherById($id)
    {
        return Teacher::with('user')->findOrFail($id);
    }

    public function createTeacher(array $data)
    {
        return Teacher::create($data);
    }

    public function updateTeacher($id, array $data)
    {
        $teacher = Teacher::where('user_id', $id)->firstOrFail();
        // $teacher = Teacher::findOrFail($id); --- IGNORE ---
        $teacher->update($data);

        return $teacher;
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);

        return $teacher->delete();
    }

    public function getTeacherCourses($id)
    {
        $teacher = Teacher::with('courses')->findOrFail($id);

        return $teacher->courses;
    }
}
