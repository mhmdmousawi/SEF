<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Request;
use Auth;
use Picture;
use DB;

class ProfileController extends Controller
{
    public function index()
    {
        
        $user = Auth::user();
        $pictures = DB::select("SELECT * from pictures where user_id = $user->id limit 1");
        
        foreach($pictures as $picture){
            $profile_pic = $picture;
        }
        

        return view("profile",array(
            'user' => $user,
            'profile_pic' => $profile_pic
        ));
    }
}
