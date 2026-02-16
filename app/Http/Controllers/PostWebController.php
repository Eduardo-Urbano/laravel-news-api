<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use App\Models\Category;

class PostWebController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::with(['category', 'user'])
                    ->latest()
                    ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->summary = $request->summary;
        $post->content = $request->content;
        $post->category_id = $request->category_id;
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.index')->with('success', 'Post criado com sucesso!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        return redirect()->route('posts.index')->with('success', 'Post atualizado com sucesso!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deletado com sucesso!');
    }
}