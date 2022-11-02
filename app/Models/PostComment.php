<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    static function getPostCommentsId(int $postId)
    {
        $postCommentsId = self::raw(
            "SELECT comment_id FROM post_comments WHERE post_id = ? ORDER BY id DESC",
            [$postId]
        )->get()->toArray();
        return array_column($postCommentsId, 'comment_id');
    }
}
