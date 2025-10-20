<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\NotFoundException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use App\Services\LessonService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;

    protected $lessonService;

    public function __construct(CommentService $commentService, LessonService $lessonService)
    {
        $this->commentService = $commentService;
        $this->lessonService = $lessonService;
    }

    public function index($lessonId)
    {
        $comments = $this->commentService->getAllComments($lessonId);

        if ($comments->isEmpty()) {
            return ResponseHelper::error('no comments found');
        }

        return ResponseHelper::success(CommentResource::collection($comments));

    }

    public function show($id)
    {
        $comment = $this->commentService->getCommentById($id);

        if (! $comment) {
            throw new NotFoundException('Comment not found');
        }

        return ResponseHelper::success(new CommentResource($comment));
    }

    public function store(CommentRequest $request, $lessonId)
    {

        $userid = Auth::id();
        $lesson = $this->lessonService->getLessonById($lessonId);

        if (! $lesson) {
            throw new NotFoundException('lesson not found');
        }
        $data = array_merge($request->validated(), ['user_id' => $userid, 'lesson_id' => $lessonId]);
        $comment = $this->commentService->createComment($data);

        return ResponseHelper::success(new CommentResource($comment), 'Comment created successfully.');

    }

    public function update(CommentRequest $request, $lessonId, $id)
    {

        $comment = $this->commentService->updateComment($id, $request->validated());

        if (! $comment) {
            throw new NotFoundException('Comment not found');
        }

        return ResponseHelper::success(new CommentResource($comment), 'Comment updated successfully.');
    }

    public function destroy($lessonId, $id)
    {
        $deleted = $this->commentService->deleteComment($id);

        if (! $deleted) {
            throw new NotFoundException('Comment not found');
        }

        return ResponseHelper::success(null, 'Comment deleted successfully.');
    }
}
