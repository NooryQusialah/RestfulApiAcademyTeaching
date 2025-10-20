<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\NotFoundException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonResource;
use App\Services\LessonService;

class LessonController extends Controller
{
    protected LessonService $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function index($courseId)
    {

        $lessons = $this->lessonService->getLessonsByCourseId((int) $courseId);

        return ResponseHelper::success(LessonResource::collection($lessons), 'Lessons fetched successfully');

    }

    public function store(LessonRequest $request)
    {
        $lesson = $this->lessonService->createLesson($request->validated());

        return ResponseHelper::success(new LessonResource($lesson), 'Lesson created successfully', 201);
    }

    public function show($id)
    {

        if (! is_numeric($id)) {
            return ResponseHelper::error('Lesson ID must be an integer.', 422);
        }

        $lesson = $this->lessonService->getLessonById((int) $id);
        if (! $lesson) {
            throw new NotFoundException('Lesson not found');
        }

        return ResponseHelper::success(new LessonResource($lesson), 'Lesson retrieved successfully');

    }

    public function update(LessonRequest $request, $id)
    {
        if (! is_numeric($id)) {
            return ResponseHelper::error('Lesson ID must be an integer.', 422);
        }

        $lesson = $this->lessonService->updateLesson((int) $id, $request->validated());
        if (! $lesson) {
            throw new NotFoundException('Lesson not found');
        }

        return ResponseHelper::success(new LessonResource($lesson), 'Lesson updated successfully');

    }

    public function destroy($id)
    {

        if (! is_numeric($id)) {
            return ResponseHelper::error('Lesson ID must be an integer.', 422);
        }

        $deleted = $this->lessonService->deleteLesson((int) $id);
        if (! $deleted) {
            throw new NotFoundException('Lesson not found');
        }

        return ResponseHelper::success(null, 'Lesson deleted successfully');
    }
}
