<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use OpenApi\Attributes as OA;

#[OA\Tag(
    name: "Categorias",
    description: "Endpoints relacionados ao gerenciamento de categorias"
)]
class CategoryController extends Controller
{
    #[OA\Get(
        path: "/api/categories",
        summary: "Lista todas as categorias",
        tags: ["Categorias"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Categorias listadas com sucesso"
            )
        ]
    )]
    public function index()
    {
        return Category::all();
    }

    #[OA\Post(
        path: "/api/categories",
        summary: "Cria uma nova categoria",
        tags: ["Categorias"],
        responses: [
            new OA\Response(
                response: 201,
                description: "Categoria criada com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            )
        ]
    )]
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json($category, 201);
    }

    #[OA\Get(
        path: "/api/categories/{id}",
        summary: "Exibe uma categoria específica",
        tags: ["Categorias"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Categoria encontrada com sucesso"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            )
        ]
    )]
    public function show(Category $category)
    {
        return $category;
    }

    #[OA\Put(
        path: "/api/categories/{id}",
        summary: "Atualiza uma categoria existente",
        tags: ["Categorias"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Categoria atualizada com sucesso"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            ),
            new OA\Response(
                response: 422,
                description: "Dados inválidos"
            )
        ]
    )]
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json($category);
    }

    #[OA\Delete(
        path: "/api/categories/{id}",
        summary: "Remove uma categoria",
        tags: ["Categorias"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Categoria removida com sucesso"
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

        return response()->json([
            'message' => 'Categoria removida com sucesso'
        ]);
    }
}
