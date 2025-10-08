<?php

namespace App\Http\Controllers\ApiController;
use App\Exceptions\Handler;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuizzeRequest;
use App\Http\Resources\QuizzeResource;
use App\Services\QuizzeService;

class QuizzeController extends Controller
{
    protected $quizService;

    public function __construct(QuizzeService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function index()
    {
        try {
            $quizzes = $this->quizService->getAllQuizzes();
            return ResponseHelper::success(QuizzeResource::collection($quizzes));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $quiz = $this->quizService->getQuizById($id);

            if (!$quiz) {
                return ResponseHelper::error('Quiz not found', 404);
            }

            return ResponseHelper::success(new QuizzeResource($quiz));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(QuizzeRequest $request)
    {
        try {
            $quiz = $this->quizService->createQuiz($request->validated());

            return ResponseHelper::success(new QuizzeResource($quiz), 'Quiz created successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(QuizzeRequest $request, $id)
    {
        try {
            $quiz = $this->quizService->updateQuiz($id, $request->validated());

            if (!$quiz) {
                return ResponseHelper::error('Quiz not found', 404);
            }

            return ResponseHelper::success(new QuizzeResource($quiz), 'Quiz updated successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->quizService->deleteQuiz($id);

            if (!$deleted) {
                return ResponseHelper::error('Quiz not found', 404);
            }

            return ResponseHelper::success(null, 'Quiz deleted successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
