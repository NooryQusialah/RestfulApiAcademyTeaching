<?php

namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Interfaces\CommentInterface;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

      public function getAll($lessonId): Collection
    {

         return Comment::with(['user', 'lesson'])->where('lesson_id', $lessonId)->get();
    }

    public function getById(int $id): ?Comment
    {
        return Comment::with(['user', 'lesson'])->findOrFail($id);
    }

    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function update(int $id, array $data): ?Comment
    {
        $comment = Comment::findOrFail($id);

        $comment->update($data);
        return $comment;
    }

    public function delete(int $id): bool
    {
        $comment = Comment::findOrFail($id);
        return $comment->delete();
    }
}
