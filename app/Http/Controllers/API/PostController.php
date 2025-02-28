<?php

namespace App\Http\Controllers\API;

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
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->latest()->paginate(10);
        return new PostCollection($posts);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function store(PostRequest $request)
    {
        $post = PostService::createPost($request->validated());
        return new PostResource($post);
    }

    public function update(PostRequest $request, Post $post)
    {
        $this->checkPost($post);
        $post = PostService::updatePost($post, $request->validated());
        return new PostResource($post);
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->checkPost($post);
        PostService::deletePost($post);

        return response()->json(['message' => 'Post deleted successfully']);
    }

    private function checkPost(Post $post): void
    {
        abort_if($post->user_id !== Auth::id(), 403, 'Unauthorized');
    }
}
