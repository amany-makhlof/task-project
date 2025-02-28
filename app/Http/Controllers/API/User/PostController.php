<?php

namespace App\Http\Controllers\API\User;

use App\Events\PostApproved;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Http\Services\PostService;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware('role:Admin,Editor')->only(['approve', 'reject']);
    }

    /**
     * Get all posts with at least X comments
     */
    public function index()
    {
        $posts = Post::with(['categories'])
            ->latest()
            ->paginate(10);

        return new PostCollection($posts);
    }

    /**
     * Show a specific post
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Store a new post (Pending Approval)
     */
    public function store(PostRequest $request)
    {
        $post = PostService::createPost($request->validated());
        return new PostResource($post);
    }

    /**
     * Update an existing post
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->checkPost($post);
        $post = PostService::updatePost($post, $request->validated());
        return new PostResource($post);
    }
    /**
     * Ensure the user owns the post before making changes
     */
    private function checkPost(Post $post): void
    {
        abort_if($post->user_id !== Auth::id(), 403, 'Unauthorized');
    }

    /**
     * Delete a post
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->checkPost($post);
        PostService::deletePost($post);

        return response()->json(['message' => 'Post deleted successfully']);
    }

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
