<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Helpers\ResponseHelper;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\TeacherResource;
use App\Services\TeacherService;
use App\Services\UserCredentialService;

class TeacherController extends Controller
{
    protected $teacherService;

    protected $userCredentialService;

    public function __construct(TeacherService $teacherService, UserCredentialService $userCredentialService)
    {
        $this->teacherService = $teacherService;
        $this->userCredentialService = $userCredentialService;
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
            if (! $teacher) {
                return ResponseHelper::error('Teacher not found', 404);
            }

            return ResponseHelper::success(new TeacherResource($teacher));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(TeacherRequest $teacherRequest, UserRegisterRequest $userRequest)
    {
        try {

            $userRequestData = $userRequest->validated();
            $user = $this->userCredentialService->register($userRequestData);
            $teacherData = array_merge($teacherRequest->validated(), ['user_id' => $user->id]);

            $teacher = $this->teacherService->createTeacher($teacherData);

            return ResponseHelper::success(new TeacherResource($teacher), 'Teacher created successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(TeacherRequest $teacherRequest, UserRegisterRequest $userRequest, $id)
    {
        try {
            $userRequestData = $userRequest->validated();
            $user = $this->userCredentialService->updateUser($userRequestData, $id);

            $teacher = $this->teacherService->updateTeacher($id, $teacherRequest->validated());

            if (! $teacher) {
                return ResponseHelper::error('Teacher not found', 404);
            }

            return ResponseHelper::success(new TeacherResource($teacher), 'Teacher updated successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $teacher = $this->teacherService->deleteTeacher($id);
            if (! $teacher) {
                return ResponseHelper::error('Teacher not found', 404);
            }

            return ResponseHelper::success(null, 'Teacher deleted successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function courses($id)
    {
        try {
            $courses = $this->teacherService->getTeacherCourses($id);
            if ($courses === null) {
                return ResponseHelper::error('Teacher not found', 404);
            }

            return ResponseHelper::success($courses);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
