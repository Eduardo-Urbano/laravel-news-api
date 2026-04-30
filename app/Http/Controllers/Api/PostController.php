<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Posts",
    description: "Endpoints relacionados ao gerenciamento, listagem, filtros e exclusão de posts"
)]
class PostController extends Controller
{
    use AuthorizesRequests;

    #[OA\Get(
        path: "/api/posts",
        summary: "Lista posts com filtros opcionais por categoria, tag e título",
        tags: ["Posts"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Posts listados com sucesso"
            )
        ]
    )]
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

    #[OA\Post(
        path: "/api/posts",
        summary: "Cria um novo post",
        tags: ["Posts"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Post criado com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            )
        ]
    )]
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return response()->json($post, 201);
    }

    #[OA\Get(
        path: "/api/posts/{id}",
        summary: "Exibe um post específico com autor e categoria",
        tags: ["Posts"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Post encontrado com sucesso"
            ),
            new OA\Response(
                response: 404,
                description: "Post não encontrado"
            )
        ]
    )]
    public function show(Post $post)
    {
        return $post->load(['user', 'category']);
    }

    #[OA\Put(
        path: "/api/posts/{id}",
        summary: "Atualiza um post existente",
        tags: ["Posts"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Post atualizado com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            ),
            new OA\Response(
                response: 403,
                description: "Sem permissão para atualizar este post"
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

        return response()->json($post);
    }

    #[OA\Delete(
        path: "/api/posts/{id}",
        summary: "Remove um post",
        tags: ["Posts"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Post deletado com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            ),
            new OA\Response(
                response: 403,
                description: "Sem permissão para deletar este post"
            ),
            new OA\Response(
                response: 404,
                description: "Post não encontrado"
            )
        ]
    )]
    public function destroy(Request $request, Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Post deletado com sucesso']);
    }
}
