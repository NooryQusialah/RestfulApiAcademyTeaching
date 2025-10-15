<?php

namespace App\Interfaces;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentInterface
{
    public function getAll($lessonId): Collection;

    public function getById(int $id): ?Comment;

    public function create(array $data): Comment;

    public function update(int $id, array $data): ?Comment;

    public function delete(int $id): bool;
}
