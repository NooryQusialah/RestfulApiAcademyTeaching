<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\Handler;
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
        try {
            $limit = $request->query('limit', 10);
            $courses = $this->courseService->getAllCourses($limit);

            return ResponseHelper::success(CourseResource::collection($courses));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $course = $this->courseService->getCourseById($id);

            if (! $course) {
                return ResponseHelper::error('Course not found.', 404);
            }

            return ResponseHelper::success(new CourseResource($course));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(CourseRequest $request)
    {
        try {
            $course = $this->courseService->createCourse($request->validated());

            return ResponseHelper::success(new CourseResource($course), 'Course created successfully.', 201);
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(CourseRequest $request, $id)
    {
        try {
            $course = $this->courseService->updateCourse($id, $request->validated());

            return ResponseHelper::success(new CourseResource($course), 'Course updated successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $this->courseService->deleteCourse($id);

            return ResponseHelper::success(null, 'Course deleted successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
