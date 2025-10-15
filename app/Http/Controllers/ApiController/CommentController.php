<?php

namespace App\Http\Controllers\ApiController;

use App\Exceptions\Handler;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use App\Services\LessonService;

class CommentController extends Controller
{
    protected $commentService;
    protected $lessonService;
    public function __construct(CommentService $commentService , LessonService $lessonService )
    {
        $this->commentService = $commentService;
        $this->lessonService  = $lessonService;
    }

    public function index($lessonId)
    {
        try {
            $comments = $this->commentService->getAllComments($lessonId);

            if ($comments->isEmpty()) {
                return ResponseHelper::error('no comments found');
            }
            return ResponseHelper::success(CommentResource::collection($comments));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $comment = $this->commentService->getCommentById($id);

            if (!$comment) {
                return ResponseHelper::error('Comment not found', 404);
            }

            return ResponseHelper::success(new CommentResource($comment));
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function store(CommentRequest $request, $lessonId)
    {
        try {
            $userid = auth()->id();
            $lesson = $this->lessonService->getLessonById($lessonId);

            if (!$lesson) {

                return ResponseHelper::error('lesson not found ');
            }
            $data= array_merge($request->validated(),['user_id' => $userid, 'lesson_id' => $lessonId]);
            // $request->merge(['user_id' => $userid, 'lesson_id' => $lessonId]);

            $comment = $this->commentService->createComment($data);

            return ResponseHelper::success(new CommentResource($comment), 'Comment created successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function update(CommentRequest $request,$lessonId, $id)
    {
        try {
            $comment = $this->commentService->updateComment($id, $request->validated());

            if (!$comment) {
                return ResponseHelper::error('Comment not found', 404);
            }

            return ResponseHelper::success(new CommentResource($comment), 'Comment updated successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }

    public function destroy( $lessonId,$id)
    {
        try {
            $deleted = $this->commentService->deleteComment($id);

            if (!$deleted) {
                return ResponseHelper::error('Comment not found', 404);
            }

            return ResponseHelper::success(null, 'Comment deleted successfully.');
        } catch (\Exception $e) {
            return Handler::handle($e);
        }
    }
}
