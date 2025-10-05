<?php

namespace App\Http\Controllers;

use App\Services\TeacherService;
use App\Http\Requests\TeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Helpers\ResponseHelper;
use App\Exceptions\Handler;

class TeacherController extends Controller
{
    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        try {
            $teachers = $this->teacherService->getAllTeachers();
            return ResponseHelper::success(TeacherResource::collection($teachers));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $teacher = $this->teacherService->getTeacherById($id);
            return ResponseHelper::success(new TeacherResource($teacher));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(TeacherRequest $request)
    {
        try {
            $teacher = $this->teacherService->createTeacher($request->validated());
            return ResponseHelper::success(new TeacherResource($teacher), 'Teacher created successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(TeacherRequest $request, $id)
    {
        try {
            $teacher = $this->teacherService->updateTeacher($id, $request->validated());
            return ResponseHelper::success(new TeacherResource($teacher), 'Teacher updated successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $this->teacherService->deleteTeacher($id);
            return ResponseHelper::success(null, 'Teacher deleted successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function courses($id)
    {
        try {
            $courses = $this->teacherService->getTeacherCourses($id);
            return ResponseHelper::success($courses);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
