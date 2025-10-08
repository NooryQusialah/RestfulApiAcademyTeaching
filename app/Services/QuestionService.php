<?php

namespace App\Services;

use App\Repositories\QuestionRepository;

class QuestionService
{
    /**
     * Create a new class instance.
     */

    protected $questionRepository;
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

     public function getAllQuestions()
    {
        return $this->questionRepository->getAll();
    }

    public function getQuestionById($id)
    {
        return $this->questionRepository->getById($id);
    }

    public function createQuestion(array $data)
    {
        return $this->questionRepository->create($data);
    }

    public function updateQuestion($id, array $data)
    {
        return $this->questionRepository->update($id, $data);
    }

    public function deleteQuestion($id)
    {
        return $this->questionRepository->delete($id);
    }
    
}
