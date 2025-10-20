<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\NotFoundException;
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

        $quizzes = $this->quizService->getAllQuizzes();

        return ResponseHelper::success(QuizzeResource::collection($quizzes));

    }

    public function show($id)
    {
        $quiz = $this->quizService->getQuizById($id);

        if (! $quiz) {
            throw new NotFoundException('Quiz not found');
        }

        return ResponseHelper::success(new QuizzeResource($quiz));

    }

    public function store(QuizzeRequest $request)
    {
        $quiz = $this->quizService->createQuiz($request->validated());

        return ResponseHelper::success(new QuizzeResource($quiz), 'Quiz created successfully.');

    }

    public function update(QuizzeRequest $request, $id)
    {
        $quiz = $this->quizService->updateQuiz($id, $request->validated());
        if (! $quiz) {
            throw new NotFoundException('Quiz not found');
        }

        return ResponseHelper::success(new QuizzeResource($quiz), 'Quiz updated successfully.');

    }

    public function destroy($id)
    {
        $deleted = $this->quizService->deleteQuiz($id);

        if (! $deleted) {
            throw new NotFoundException('Quiz not found');
        }

        return ResponseHelper::success(null, 'Quiz deleted successfully.');
    }
}
