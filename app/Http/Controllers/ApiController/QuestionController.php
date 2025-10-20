<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\NotFoundException;
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

        $questions = $this->questionService->getAllQuestions();

        return ResponseHelper::success(QuestionResource::collection($questions));

    }

    public function show($id)
    {

        $question = $this->questionService->getQuestionById($id);

        if (! $question) {
            throw new NotFoundException('Question not found');
        }

        return ResponseHelper::success(new QuestionResource($question));
    }

    public function store(QuestionRequest $request)
    {

        $question = $this->questionService->createQuestion($request->validated());

        return ResponseHelper::success(new QuestionResource($question), 'Question created successfully.');
    }

    public function update(QuestionRequest $request, $id)
    {

        $question = $this->questionService->updateQuestion($id, $request->validated());

        if (! $question) {
            throw new NotFoundException('Question not found');
        }

        return ResponseHelper::success(new QuestionResource($question), 'Question updated successfully.');

    }

    public function destroy($id)
    {

        $deleted = $this->questionService->deleteQuestion($id);
        if (! $deleted) {
            throw new NotFoundException('Question not found');
        }

        return ResponseHelper::success(null, 'Question deleted successfully.');

    }
}
