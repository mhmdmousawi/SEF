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
        $picture = DB::select("SELECT * from pictures where user_id = $user->id limit 1");
        
        // return $picture.child->URL;
            
        //$picture = "default.png";
        

        return view("profile",array(
            'user' => $user,
            'picture' => $profilePic
        ));
    }
}
