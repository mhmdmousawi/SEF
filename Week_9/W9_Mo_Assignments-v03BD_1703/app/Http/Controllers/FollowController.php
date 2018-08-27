<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Follow;

class FollowController extends Controller
{
    //need to add validation on private profiles
    public function follow($user_id){
        
        $user_following = Auth::user();
        $follow = new Follow;
        $follow->user_id_following = $user_following->id;
        $follow->user_id_followed = $user_id;
        $follow->save();

        return redirect()->back();
    }

    public function unfollow($user_id){

        $user_following = Auth::user();
        $follow = Follow::where('user_id_following',$user_following->id)
                        ->where('user_id_followed',$user_id)
                        ->get()
                        ->first()
                        ->delete();

        return redirect()->back();
        
    }
}
