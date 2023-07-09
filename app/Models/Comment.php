<?php

namespace App\Models;

use App\Http\Controllers\PostCommentController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class Comment extends Model
{
    static function getComments(array $commentsIds)
    {
        return self::whereIn('id', $commentsIds)->get()->toArray();
    }

    static function getCommentsWithReplays(array $commentsIds): array
    {
        $allCommentsIds = $commentsIds;
        do {
            $replyComments = self::whereIn('reply_comment_id', $commentsIds)->get()->toArray();
            $commentsIds = array_column($replyComments, 'id');
            $allCommentsIds = array_merge($allCommentsIds, $commentsIds);
        } while ($commentsIds);

        $comments = Comment::getComments($allCommentsIds);

        $level1 = array_values(
            array_filter(
                $comments,
                function ($var) {
                    return ($var['level'] == 1);
                }
            )
        );
        $level2 = array_values(
            array_filter(
                $comments,
                function ($var) {
                    return ($var['level'] == 2);
                }
            )
        );
        $level3 = array_values(
            array_filter(
                $comments,
                function ($var) {
                    return ($var['level'] == 3);
                }
            )
        );

        foreach ($level3 as $comment3) {
            $mainCommentPosition = array_search($comment3['reply_comment_id'], array_column($level2, 'id'));
            $level2[$mainCommentPosition]['replays'][] = $comment3;
        }
        foreach ($level2 as $comment2) {
            $mainCommentPosition = array_search($comment2['reply_comment_id'], array_column($level1, 'id'));
            $level1[$mainCommentPosition]['replays'][] = $comment2;
        }

        usort(
            $level1,
            function ($a, $b) {
                return $a['id'] < $b['id'];
            }
        );
        return $level1;
    }


    /**
     * @throws \Exception
     */
    static function saveComment(
        string $uuid,
        string $username,
        string $text,
        int $level
    ): bool {
        if ($level == 1) {
            return PostCommentController::savePostComment(
                $uuid,
                $username,
                $text
            );
        }

        $replyComment = self::select("id")->where('uuid', $uuid)->first() ?? null;

        if (!$replyComment) {
            throw new \Exception('Main comment not found. Please enter a valid uuid');
        }

        return self::insertNewComment(
            $username,
            $text,
            $level,
            $replyComment->id
        );
    }

    static function insertNewComment(
        string $username,
        string $text,
        int $level = 1,
        string $replyId = null
    ): bool {
        return DB::insert(
            "INSERT INTO comments (`uuid`, `username`, `text`, `level`, `reply_comment_id`, `created_at`, `updated_at`)
                VALUES (?, ?, ?, ?, ?, ?, ?)",
            [
                Uuid::uuid4(),
                $username,
                $text,
                $level,
                $replyId,
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s'),
            ]
        );
    }

    static function editComment(
        string $uuid,
        string $username,
        string $text
    ): bool {
        return DB::update(
            'UPDATE comments SET username = ?, text = ? WHERE uuid = ?',
            [$username, $text, $uuid]
        );
    }

    static function deleteComment(
        string $uuid
    ): bool {
        return DB::update(
            'DELETE FROM comments WHERE uuid = ?',
            [$uuid]
        );
    }
}
''