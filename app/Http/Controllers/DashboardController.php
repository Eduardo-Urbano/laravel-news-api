<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Dashboard",
    description: "Endpoints relacionados ao painel principal da aplicação web"
)]
class DashboardController extends Controller
{
    #[OA\Get(
        path: "/dashboard",
        summary: "Exibe o dashboard com posts recentes e categorias",
        tags: ["Dashboard"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Dashboard carregado com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function index()
    {
        $posts = Post::latest()->take(5)->get();
        $categories = Category::withCount('posts')->get();

        return view('dashboard', compact('posts', 'categories'));
    }
}
