<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picture;

class FeedController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Picture::all();
        // return $posts;
        return view('feed')->with('posts',$posts);
    }
}
