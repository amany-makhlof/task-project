<?php

namespace App\Http\Services;

use App\Jobs\NotifyAdminsOfNewPost;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostApprovalNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PostService
{
    public static function createPost(array $data): Post
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => 'pending', // New posts require admin approval
        ]);

        // Attach categories if provided
        if (!empty($data['categories'])) {
            $post->categories()->attach($data['categories']);
        }


        dispatch(new NotifyAdminsOfNewPost($post));

        return $post;
    }

    public static function updatePost(Post $post, array $data): Post
    {
        self::authorizePost($post);

        $post->update([
            'title' => $data['title'],
            'content' => $data['content'],
            'status' => 'pending', // Updates also require admin review
        ]);

        if (!empty($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

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
        abort_if($post->user_id !== Auth::id(), 403, 'Unauthorized');
    }

    // Approve post
    public static function approvePost(Post $post): void
    {
        $post->update(['status' => 'approved']);

        // Notify author
        $post->user->notify(new PostApprovalNotification($post));
    }

    // Reject post
    public static function rejectPost(Post $post): void
    {
        $post->update(['status' => 'rejected']);

        // Notify author
        $post->user->notify(new PostApprovalNotification($post));
    }

    // Retrieve posts with at least X comments
    public static function getPostsWithComments($count)
    {
        return Post::whereHas('comments', function ($query) use ($count) {
            $query->havingRaw("COUNT(comments.id) >= ?", [$count]);
        })->get();
    }
}
