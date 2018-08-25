<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadPictureController extends Controller
{
    public function index(Request $request)
    {
        //upload picture


        //test 
        //return $request["picture"];
        //$posts = Picture::all();
        // return $posts;
        //return view('feed')->with('posts',$posts);

        
        $file = $request->file('picture');
        
        //$filename = $request['first_name'] . '-' . $user->id . '.jpg';
        //$old_filename = $old_name . '-' . $user->id . '.jpg';
        //$update = false;

        if ($file) {
            return "fe soora";
            Storage::disk('local')->put("picture1.jpg", File::get($file));
        }
        return "nooop";
        
        //return redirect()->route('\feed');
    }
}
