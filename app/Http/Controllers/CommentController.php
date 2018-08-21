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

    // List all user comments
    public function index()
    {
        $comments = Comment::with(['user','itinerary.user'])->get();

        return view('comments', ['comments' => $comments]);
    }

    // Delete user comments
    public function destroy(Request $request)
    {
        $comment_id = $request->comment_id;

        $comment = Comment::find($comment_id);

        // delete data
        $comment->delete();

        return redirect('comments')->with('deletestatus', 'Delete comment ID: '.$request->comment_id.' success!');
    }
}
