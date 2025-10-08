<?php

namespace App\Interfaces;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

interface QuestionInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?Question;

    public function create(array $data): Question;

    public function update(int $id, array $data): ?Question;

    public function delete(int $id): bool;
}
