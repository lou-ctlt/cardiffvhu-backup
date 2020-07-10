<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Photo;
use App\User;
use App\Folder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        $user_id = Auth::user()->id;
        $folders = Folder::where("user_id", $user_id)->orderBy('name', 'asc')->get();
        $folder_id = Folder::where("user_id", $user_id)->get('id');
        $photos = Photo::where("user_id", $user_id)->get();

        return view('home')->with('photos', $photos)->with('folders', $folders)->with('users', $users);
    }
}