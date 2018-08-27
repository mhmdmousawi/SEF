<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PostController extends Controller
{
    public function addPost(){

        $user = Auth::user();
        return view("add_post",array(
            'user' => $user
        ));
    }
}
