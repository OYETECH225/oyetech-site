<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('pages.blog.index', [
            'articles' => Article::published()->latest('published_at')->paginate(9),
        ]);
    }

    public function show(Article $article): View
    {
        return view('pages.blog.show', [
            'article' => $article,
            'related' => Article::published()
                ->where('category', $article->category)
                ->where('id', '!=', $article->id)
                ->take(3)
                ->get(),
        ]);
    }
}
