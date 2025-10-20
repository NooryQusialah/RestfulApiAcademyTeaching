<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
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
        $teachers = $this->teacherService->getAllTeachers();

        return ResponseHelper::success(TeacherResource::collection($teachers));

    }

    public function show($id)
    {

        $teacher = $this->teacherService->getTeacherById($id);
        if (! $teacher) {
            throw new NotFoundException('Teacher not found.');
        }

        return ResponseHelper::success(new TeacherResource($teacher));

    }

    public function store(TeacherRequest $teacherRequest, UserRegisterRequest $userRequest)
    {

        $userRequestData = $userRequest->validated();
        $user = $this->userCredentialService->register($userRequestData);
        $teacherData = array_merge($teacherRequest->validated(), ['user_id' => $user->id]);

        $teacher = $this->teacherService->createTeacher($teacherData);

        return ResponseHelper::success(new TeacherResource($teacher), 'Teacher created successfully.');

    }

    public function update(TeacherRequest $teacherRequest, UserRegisterRequest $userRequest, $id)
    {
        $userRequestData = $userRequest->validated();
        $user = $this->userCredentialService->updateUser($userRequestData, $id);

        $teacher = $this->teacherService->updateTeacher($id, $teacherRequest->validated());

        if (! $teacher) {
            return ResponseHelper::error('Teacher not found', 404);
        }

        return ResponseHelper::success(new TeacherResource($teacher), 'Teacher updated successfully.');

    }

    public function destroy($id)
    {

        $teacher = $this->teacherService->deleteTeacher($id);
        if (! $teacher) {
            return ResponseHelper::error('Teacher not found', 404);
        }

        return ResponseHelper::success(null, 'Teacher deleted successfully.');

    }

    public function courses($id)
    {

        $courses = $this->teacherService->getTeacherCourses($id);
        if ($courses === null) {
            return ResponseHelper::error('Teacher not found', 404);
        }

        return ResponseHelper::success($courses);

    }
}
