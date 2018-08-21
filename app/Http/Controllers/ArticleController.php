<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Http\Controllers\APIController;
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
        $APIobj = new APIController();
        $articles = $APIobj->listArticles();

        return view('articles', ['articles' => $articles]);
    }

    // Display create form
    public function create()
    {
        return view('create_article');
    }

    // Insert article to database
    public function store(Request $request)
    {
        $rules = array(
          'title' => 'required|string|max:255',
          'author' => 'required|string|max:255',
          'date' => 'required|date',
          'summary' => 'required|string|max:255',
          'content' => 'required|string',
        );

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails())
        {
            $errors = $validator->errors();

            return redirect('articles/create')->with('errors', $errors);
        }
        else
        {
            $article = new Article;

            $article->title = $request->title;
            $article->author = $request->author;
            $article->date = $request->date;
            $article->summary = $request->summary;
            $article->content = $request->content;

            $article->save();

            return redirect('articles/create')->with('success', "Article created!");
        }
    }

    // Delete an article
    public function destroy(Request $request)
    {
        $article_id = $request->article_id;

        // Delete the itinerary
        $article = Article::find($article_id);
        $article->delete();

        return redirect('articles')->with('deletestatus', 'Delete article ID: '.$request->article_id.' success!');
    }
}
