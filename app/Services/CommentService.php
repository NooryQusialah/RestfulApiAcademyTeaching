<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentService
{
    /**
     * Create a new class instance.
     */

    protected $commentRepository;
    public function __construct(CommentRepository $commentRepository )
    {
        $this->commentRepository = $commentRepository;
    }


    public function getAllComments($lessonId)
    {
        return $this->commentRepository->getAll($lessonId);
    }

    public function getCommentById($id)
    {
        return $this->commentRepository->getById($id);
    }

    public function createComment(array $data)
    {
        return $this->commentRepository->create($data);
    }

    public function updateComment($id, array $data)
    {
        return $this->commentRepository->update($id, $data);
    }

    public function deleteComment($id)
    {
        return $this->commentRepository->delete($id);
    }
}
