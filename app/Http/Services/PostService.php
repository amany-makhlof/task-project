<?php

namespace App\Http\Services;

use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public static function getPostById($id)
    {
        $post = Post::findOrFail($id);
        self::authorizePost($post);
        return $post;
    }

    public static function createPost(array $data): Post
    {
        return Post::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'content' => $data['content'],
        ]);
    }

    public static function updatePost(Post $post, array $data): Post
    {

        self::authorizePost($post);
        $post->update([
            'title' => $data['title'],
            'content' => $data['content'],
        ]);

        return $post;
    }

    public static function deletePost(Post $post): void
    {
        self::authorizePost($post);
        $post->delete();
    }

    private static function authorizePost(Post $post): void
    {
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
