<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiEditCommentRequest;
use App\Http\Requests\ApiSaveCommentRequest;
use App\Http\Requests\SaveCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class CommentController extends Controller
{
    public function save(SaveCommentRequest $request)
    {
        Comment::saveComment(
            $request->uuid,
            $request->username,
            $request->comment,
            $request->level
        );
        return redirect(route('/'));
    }

    public function saveApi(ApiSaveCommentRequest $request)
    {
        try {
            Comment::saveComment(
                $request->uuid,
                $request->username,
                $request->comment,
                $request->level
            );
            return $this->responseBody('Saved');
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }

    public function editApi(ApiEditCommentRequest $request, $commentUuid)
    {
        try {
            Comment::editComment(
                $commentUuid,
                $request->username,
                $request->comment
            );
            return $this->responseBody('Saved');
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }
    public function deleteApi($commentUuid)
    {
        try {
            Comment::deleteComment(
                $commentUuid
            );
            return $this->responseBody('Deleted');
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }
}
