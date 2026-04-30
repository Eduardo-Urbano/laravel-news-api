<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use App\Models\Category;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Posts Web",
    description: "Endpoints relacionados ao gerenciamento de posts via interface web"
)]
class PostWebController extends Controller
{
    use AuthorizesRequests;

    #[OA\Get(
        path: "/posts",
        summary: "Lista posts paginados no painel web",
        tags: ["Posts Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Posts listados com sucesso"
            )
        ]
    )]
    public function index()
    {
        $posts = Post::with(['category', 'user'])
                    ->latest()
                    ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    #[OA\Get(
        path: "/posts/create",
        summary: "Exibe a página de criação de post",
        tags: ["Posts Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de criação carregada com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    #[OA\Post(
        path: "/posts",
        summary: "Cria um novo post via painel web",
        tags: ["Posts Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Post criado com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
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

    #[OA\Get(
        path: "/posts/{id}/edit",
        summary: "Exibe a página de edição de um post",
        tags: ["Posts Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de edição carregada com sucesso"
            ),
            new OA\Response(
                response: 403,
                description: "Sem permissão"
            ),
            new OA\Response(
                response: 404,
                description: "Post não encontrado"
            )
        ]
    )]
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::all();

        return view('posts.edit', compact('post', 'categories'));
    }

    #[OA\Put(
        path: "/posts/{id}",
        summary: "Atualiza um post existente via painel web",
        tags: ["Posts Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Post atualizado com sucesso"
            ),
            new OA\Response(
                response: 403,
                description: "Sem permissão"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            )
        ]
    )]
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        return redirect()->route('posts.index')->with('success', 'Post atualizado com sucesso!');
    }

    #[OA\Delete(
        path: "/posts/{id}",
        summary: "Remove um post via painel web",
        tags: ["Posts Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Post deletado com sucesso"
            ),
            new OA\Response(
                response: 403,
                description: "Sem permissão"
            ),
            new OA\Response(
                response: 404,
                description: "Post não encontrado"
            )
        ]
    )]
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deletado com sucesso!');
    }
}
