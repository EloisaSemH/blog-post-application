<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentsComment;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostCommentController extends Controller
{

    static function getPostComments(int $postId)
    {
        $commentsIds = PostComment::getPostCommentsId($postId);

        return Comment::getCommentsWithReplays($commentsIds);
    }

    static function savePostComment(
        string $postUuid,
        string $username,
        string $text
    ): bool {
        try {
            $postData = Post::raw("SELECT id FROM posts where uuid = ?", [$postUuid])->first()->toArray();

            if (!$postData) {
                throw new \Exception();
            }

            Comment::insertNewComment(
                $username,
                $text
            );

            $commentId = DB::getPdo()->lastInsertId();

            if (!$commentId) {
                throw new \Exception();
            }

            return DB::insert(
                "INSERT INTO post_comments (`post_id`, `comment_id`) VALUES (?, ?)",
                [
                    $postData['id'],
                    $commentId,
                ]
            );
        } catch (\Exception $exception) {
            throw new \Exception(
                'Sorry, occurred an error trying to save your comment. Message:' . $exception->getMessage()
            );
        }
    }
}
