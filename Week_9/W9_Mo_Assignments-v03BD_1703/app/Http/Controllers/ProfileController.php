<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
//use App\Http\Request;
use Auth;
use App\Picture;
use App\Post;
use DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $ppicture = Picture::where('user_id',$user->id )
                            ->where('URL', 'like','profile_picture%')
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->first();
        //add condition on deleted posts later
        $posts = Post::where('user_id',$user->id)->get();

        //assign defauls img if there is no profile pic
        if($ppicture){
            $profile_pic = $ppicture;
            $profile_pic->source = $user->id."/".$ppicture->URL;
        }else{
            $profile_pic =  new Picture;
            $profile_pic->source = "default.png";
        }

        //link pictures to posts
        if(count($posts)>0){
            foreach($posts as $post){
                $post_pic = Picture::where('id',$post->picture_id )->get()->first();
                $post->pic = $post_pic;
            }
        }
        
        return view("profile",array(
            'user' => $user,
            'profile_pic' => $profile_pic,
            'posts' => $posts
        ));
    }
}
