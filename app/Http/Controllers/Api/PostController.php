<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])->latest();

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('tag')) {
            $query->where('tag', 'like', '%' . $request->tag . '%');
        }

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        $posts = $query->paginate(10)->withQueryString();

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return $post->load(['user', 'category']);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $post->update($request->validated());

        return response()->json($post);
    }

    public function destroy(Request $request, Post $post)
    {
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Não autorizado'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deletado com sucesso']);
    }
}