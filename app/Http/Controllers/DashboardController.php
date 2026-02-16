<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->take(5)->get();
        $categories = Category::withCount('posts')->get();

        return view('dashboard', compact('posts', 'categories'));
    }
}