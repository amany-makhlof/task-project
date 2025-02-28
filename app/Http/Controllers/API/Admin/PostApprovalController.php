<?php

namespace App\Http\Controllers\API\Admin;

use App\Events\PostApproved;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostApprovalController extends Controller
{
    /**
     * Approve a post
     */
    public function approve(Post $post)
    {
        if (!Auth::user()->hasRole('Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->update(['status' => 'approved']);
        event(new PostApproved($post));

        return response()->json(['message' => 'Post approved successfully']);
    }

    /**
     * Reject a post
     */
    public function reject(Post $post)
    {
        if (!Auth::user()->hasRole('Admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->update(['status' => 'rejected']);

        return response()->json(['message' => 'Post rejected successfully']);
    }
}
