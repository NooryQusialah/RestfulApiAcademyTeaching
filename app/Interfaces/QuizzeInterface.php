<?php

namespace App\Interfaces;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;

interface QuizzeInterface
{
    public function getAll(): Collection;

    public function getById(int $id): ?Quiz;

    public function create(array $data): Quiz;

    public function update(int $id, array $data): ?Quiz;

    public function delete(int $id): bool;
}
