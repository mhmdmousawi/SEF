<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Image;
//sudo apt-get install php7.2-gd
use Auth;
use App\Picture;
use App\Post;

class UploadPictureController extends Controller
{

    public function profile_picture(Request $request)
    {

        $this->validate($request,[
            'profile_pic' =>'required|image|mimes:jpg,jpeg,png'
        ]);
        
        if($request->hasFile("profile_pic")){

            $user = Auth::user();
            $profile_pic = $request->file('profile_pic');
            $file_name = "profile_picture.". $profile_pic->getClientOriginalExtension();

            //create a diretory for user if doesn't exist
            $path_user_dir = public_path('/uploads/users/'.$user->id.'/');
            if(!File::exists($path_user_dir)) {
                File::makeDirectory($path_user_dir, 0777);
            }

            //add img to user's directory
            Image::make($profile_pic)
                        ->resize(300,300)
                        ->save( public_path('/uploads/users/' . $user->id ."/" . $file_name ) );
            
            $picture = new Picture;
            $picture->user_id = $user->id;
            $picture->URL = $file_name;
            $picture->save();

            $user->profile_picture_id = $picture->id;
            $user->save();

        }

        return redirect('/profile');
    }

    public function post_picture(Request $request)
    {
        $this->validate($request,[
            'post_pic' =>'required|image|mimes:jpg,jpeg,png'
        ]);

        if($request->hasFile("post_pic")){

            $user = Auth::user();
            $post_pic = $request->file('post_pic');
            $file_name = $post_pic->getClientOriginalName(); //. $post_pic->getClientOriginalExtension();
            

            //create a diretory for user if doesn't exist
            $path_user_dir = public_path('/uploads/users/'.$user->id.'/');
            if(!File::exists($path_user_dir)) {
                File::makeDirectory($path_user_dir, 0777);
            }

            //create a diretory for user posts if doesn't exist
            $path_posts_dir = public_path('/uploads/users/'.$user->id.'/posts/');
            if(!File::exists($path_posts_dir)) {
                File::makeDirectory($path_posts_dir, 0777);
            }

            //create the image uploaded as a post
            Image::make($post_pic)
                        ->resize(300,300)
                        ->save(  $path_posts_dir. $file_name );

            //add to DB as picture
            $picture = new Picture;
            $picture->user_id = $user->id;
            $picture->URL = $file_name;
            $picture->save();

            //add ro DB as post
            $post = new Post;
            $post->user_id = $user->id;
            $post->picture_id = $picture->id;
            $post->save();

        }

        return redirect('/profile');
    }
}
