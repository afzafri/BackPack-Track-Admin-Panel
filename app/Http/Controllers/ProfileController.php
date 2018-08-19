<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    // Display profile data
    public function index()
    {
        $user = Auth::user();

        return view('profile', ['user' => $user]);
    }
}
