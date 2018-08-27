<?php

namespace App\Http\Controllers;
use Auth;
use App\Like;

use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function like($post_id){
        
        $user_liking = Auth::user();
        $like = new Like;
        $like->post_id = $post_id;
        $like->user_liking_id = $user_liking->id;
        $like->save();

        return redirect()->back();
    }

    public function unlike($post_id){

        $user_following = Auth::user();
        $like = Like::where('post_id',$post_id)
                        ->where('user_liking_id',$user_following->id)
                        ->get()
                        ->first()
                        ->delete();

        return redirect()->back();
        
    }
}
