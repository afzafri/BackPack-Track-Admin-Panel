<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\APIController;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    // List all itineraries
    public function index()
    {
        $users = User::with(['country'])->get();

        return view('users', ['users' => $users]);
    }

    // Delete user data
    public function destroy(Request $request)
    {
        $user_id = $request->user_id;

        $user = User::find($user_id);

        // delete image
        $APIobj = new APIController();
        $avatar_url = $user->avatar_url;
        $avatar_url = $APIobj->deletePhoto($avatar_url);

        // delete data
        $user->delete();

        return redirect('users')->with('deletestatus', 'Delete user ID: '.$request->user_id.' success!');
    }
}
