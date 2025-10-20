<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\NotFoundException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    public function index(Request $request)
    {

        $limit = $request->query('limit', 10);
        $courses = $this->courseService->getAllCourses($limit);

        return ResponseHelper::success(CourseResource::collection($courses));

    }

    public function show($id)
    {

        $course = $this->courseService->getCourseById($id);

        if (! $course) {
            throw new NotFoundException('Course not found');
        }

        return ResponseHelper::success(new CourseResource($course));

    }

    public function store(CourseRequest $request)
    {
        $course = $this->courseService->createCourse($request->validated());

        return ResponseHelper::success(new CourseResource($course), 'Course created successfully.', 201);

    }

    public function update(CourseRequest $request, $id)
    {

        $course = $this->courseService->updateCourse($id, $request->validated());

        return ResponseHelper::success(new CourseResource($course), 'Course updated successfully.');

    }

    public function destroy($id)
    {

        $this->courseService->deleteCourse($id);

        return ResponseHelper::success(null, 'Course deleted successfully.');

    }
}
