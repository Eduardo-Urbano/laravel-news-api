<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Categorias Web",
    description: "Endpoints relacionados ao gerenciamento de categorias via interface web"
)]
class CategoryController extends Controller
{
    #[OA\Get(
        path: "/categories",
        summary: "Lista categorias com contagem de posts",
        tags: ["Categorias Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de categorias exibida com sucesso"
            )
        ]
    )]
    public function index()
    {
        $categories = Category::withCount('posts')->paginate(10);

        return view('categories.index', compact('categories'));
    }

    #[OA\Get(
        path: "/categories/create",
        summary: "Exibe a página de criação de categoria",
        tags: ["Categorias Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de criação carregada com sucesso"
            )
        ]
    )]
    public function create()
    {
        return view('categories.create');
    }

    #[OA\Get(
        path: "/categories/{id}",
        summary: "Exibe uma categoria específica",
        tags: ["Categorias Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Categoria exibida com sucesso"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            )
        ]
    )]
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    #[OA\Post(
        path: "/categories",
        summary: "Cria uma nova categoria",
        tags: ["Categorias Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Categoria criada com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            )
        ]
    )]
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso!');
    }

    #[OA\Get(
        path: "/categories/{id}/edit",
        summary: "Exibe a página de edição de categoria",
        tags: ["Categorias Web"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Página de edição carregada com sucesso"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            )
        ]
    )]
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    #[OA\Put(
        path: "/categories/{id}",
        summary: "Atualiza uma categoria existente",
        tags: ["Categorias Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Categoria atualizada com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            )
        ]
    )]
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    #[OA\Delete(
        path: "/categories/{id}",
        summary: "Remove uma categoria",
        tags: ["Categorias Web"],
        responses: [
            new OA\Response(
                response: 302,
                description: "Categoria deletada com sucesso"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            )
        ]
    )]
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria deletada com sucesso!');
    }
}
