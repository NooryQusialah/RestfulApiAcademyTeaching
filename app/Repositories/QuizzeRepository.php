<?php

namespace App\Repositories;

use App\Interfaces\QuizzeInterface;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

class QuizzeRepository implements QuizzeInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAll(): Collection
    {
        return Quiz::with('course')->get();
    }

    public function getById(int $id): ?Quiz
    {
        return Quiz::with(['course', 'questions'])->findOrFail($id);
    }

    public function create(array $data): Quiz
    {
        return Quiz::create($data);
    }

    public function update(int $id, array $data): ?Quiz
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->update($data);
        return $quiz;
    }

    public function delete(int $id): bool
    {
        $quiz = Quiz::findOrFail($id);
        
        return $quiz->delete();

    }
}
