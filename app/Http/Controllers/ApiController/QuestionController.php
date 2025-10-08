<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\Handler;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        try {
            $questions = $this->questionService->getAllQuestions();
            return ResponseHelper::success(QuestionResource::collection($questions));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $question = $this->questionService->getQuestionById($id);

            if (!$question) {
                return ResponseHelper::error('Question not found', 404);
            }

            return ResponseHelper::success(new QuestionResource($question));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(QuestionRequest $request)
    {
        try {
            $question = $this->questionService->createQuestion($request->validated());

            return ResponseHelper::success(new QuestionResource($question), 'Question created successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(QuestionRequest $request, $id)
    {
        try {
            $question = $this->questionService->updateQuestion($id, $request->validated());

            if (!$question) {
                return ResponseHelper::error('Question not found', 404);
            }

            return ResponseHelper::success(new QuestionResource($question), 'Question updated successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->questionService->deleteQuestion($id);

            if (!$deleted) {
                return ResponseHelper::error('Question not found', 404);
            }

            return ResponseHelper::success(null, 'Question deleted successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
