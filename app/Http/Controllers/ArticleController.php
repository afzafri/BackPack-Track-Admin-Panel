<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Article;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    // List all articles posted
    public function index()
    {
        $articles = Article::all();

        return view('articles', ['articles' => $articles]);
    }

    // Display create form
    public function create()
    {
        return view('create_article');
    }
}
