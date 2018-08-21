<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\User;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    // List all itineraries
    public function index()
    {
        $comments = Comment::with(['user','itinerary.user'])->get();

        return view('comments', ['comments' => $comments]);
    }
}
