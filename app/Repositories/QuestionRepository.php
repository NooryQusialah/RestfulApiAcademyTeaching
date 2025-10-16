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
        return Question::with('quiz')->find($id);
    }

    public function create(array $data): Question
    {
        return Question::create($data);
    }

    public function update(int $id, array $data): ?Question
    {
        $question = Question::find($id);
        if (! $question) {
            return null;
        }
        $question->update($data);

        return $question;
    }

    public function delete(int $id): bool
    {
        $question = Question::find($id);
        if (! $question) {
            return false;
        }

        return $question->delete();
    }
}
