<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\Handler;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonResource;
use App\Services\LessonService;
use Exception;

class LessonController extends Controller
{
    protected LessonService $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function index($courseId)
    {
        try {
            $lessons = $this->lessonService->getLessonsByCourseId((int) $courseId);

            return ResponseHelper::success(LessonResource::collection($lessons), 'Lessons fetched successfully');
        } catch (Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(LessonRequest $request)
    {
        try {
            $lesson = $this->lessonService->createLesson($request->validated());

            return ResponseHelper::success(new LessonResource($lesson), 'Lesson created successfully', 201);
        } catch (Exception $e) {
            return Handler::handle($e);
        }
    }

    public function show($id)
    {
        try {
            if (! is_numeric($id)) {
                return ResponseHelper::error('Lesson ID must be an integer.', 422);
            }

            $lesson = $this->lessonService->getLessonById((int) $id);
            if (! $lesson) {
                return ResponseHelper::error('Lesson not found.', 404);
            }

            return ResponseHelper::success(new LessonResource($lesson), 'Lesson retrieved successfully');
        } catch (Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(LessonRequest $request, $id)
    {
        try {
            if (! is_numeric($id)) {
                return ResponseHelper::error('Lesson ID must be an integer.', 422);
            }

            $lesson = $this->lessonService->updateLesson((int) $id, $request->validated());
            if (! $lesson) {
                return ResponseHelper::error('Lesson not found.', 404);
            }

            return ResponseHelper::success(new LessonResource($lesson), 'Lesson updated successfully');
        } catch (Exception $e) {
            return Handler::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            if (! is_numeric($id)) {
                return ResponseHelper::error('Lesson ID must be an integer.', 422);
            }

            $deleted = $this->lessonService->deleteLesson((int) $id);
            if (! $deleted) {
                return ResponseHelper::error('Lesson not found.', 404);
            }

            return ResponseHelper::success(null, 'Lesson deleted successfully');
        } catch (Exception $e) {
            return Handler::handle($e);
        }
    }
}
