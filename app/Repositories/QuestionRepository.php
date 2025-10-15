<?php

namespace App\Repositories;

use App\Interfaces\QuestionInterface;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionRepository implements QuestionInterface
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
        return Question::with('quiz')->get();
    }

    public function getById(int $id): ?Question
    {
        return Question::with('quiz')->findOrFail($id);
    }

    public function create(array $data): Question
    {
        return Question::create($data);
    }

    public function update(int $id, array $data): ?Question
    {
        $question = Question::findOrFail($id);
        $question->update($data);

        return $question;
    }

    public function delete(int $id): bool
    {
        $question = Question::findOrFail($id);

        return $question->delete();
    }
}
