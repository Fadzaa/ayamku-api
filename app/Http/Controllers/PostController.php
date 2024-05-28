<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() : JsonResponse
    {
        $posts = Post::all();

        return response()->json([
            'data' => PostResource::collection($posts)
        ]);
    }

    public function store(PostRequest $request) : JsonResponse
    {
        $data = $request->validated();

        $post = new Post();
        $post->fill($data);
        $post->save();

        return response()->json([
            'message' => 'Post created successfully',
            'data' => new PostResource($post)
        ], 201);
    }

    public function update(PostUpdateRequest $request, $id) : JsonResponse
    {
        $data = $request->validated();

        $post = Post::all()->find($id);
        $post->fill($data);
        $post->save();

        return response()->json([
            'message' => 'Post updated successfully',
            'data' => new PostResource($post)
        ]);
    }

    public function destroy($id) : JsonResponse
    {
        $post = Post::all()->find($id);
        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully'
        ]);
    }


}
