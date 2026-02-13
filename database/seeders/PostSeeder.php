<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $categories = Category::all();

        foreach ($categories as $category) {
            Post::create([
                'title' => "Notícia sobre {$category->name}",
                'tag' => strtolower($category->name),
                'summary' => "Resumo da notícia de {$category->name}",
                'content' => "Conteúdo completo da notícia relacionada a {$category->name}.",
                'category_id' => $category->id,
                'user_id' => $user->id,
            ]);
        }
    }
}