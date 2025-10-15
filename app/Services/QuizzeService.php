<?php

namespace App\Services;

use App\Repositories\QuizzeRepository;

class QuizzeService
{
    /**
     * Create a new class instance.
     */
    protected $quizRepository;

    public function __construct(QuizzeRepository $quizzeRepository)
    {
        $this->quizRepository = $quizzeRepository;
    }

    public function getAllQuizzes()
    {
        return $this->quizRepository->getAll();
    }

    public function getQuizById($id)
    {
        return $this->quizRepository->getById($id);
    }

    public function createQuiz(array $data)
    {
        return $this->quizRepository->create($data);
    }

    public function updateQuiz($id, array $data)
    {
        return $this->quizRepository->update($id, $data);
    }

    public function deleteQuiz($id)
    {
        return $this->quizRepository->delete($id);
    }
}
