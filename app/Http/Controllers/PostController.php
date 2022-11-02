<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function show()
    {
        return view(
            'index',
            $this->getPostData()
        );
    }

    public function api()
    {
        try {
            return $this->responseBody('Success', $this->getPostData());
        } catch (\Exception $exception) {
            return $this->responseError($exception->getMessage());
        }
    }

    private function getPostData(): array
    {
        $post = $this->post->getLastOne();
        $postComments = PostCommentController::getPostComments($post['id']);

        return [
            'post' => $post,
            'comments' => $postComments,
        ];
    }
}
