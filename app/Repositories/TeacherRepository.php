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
        return Teacher::with('user')->find($id);
    }

    public function createTeacher(array $data)
    {
        return Teacher::create($data);
    }

    public function updateTeacher($id, array $data)
    {
        $teacher = Teacher::where('user_id', $id)->first();
        if (! $teacher) {
            return null;
        }
        $teacher->update($data);

        return $teacher;
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::find($id);
        if (! $teacher) {
            return null;
        }

        return $teacher->delete();
    }

    public function getTeacherCourses($id)
    {
        $teacher = Teacher::with('courses')->find($id);

        return $teacher->courses;
    }
}
