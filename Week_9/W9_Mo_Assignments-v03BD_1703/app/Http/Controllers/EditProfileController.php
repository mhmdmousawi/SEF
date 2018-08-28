<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class EditProfileController extends Controller
{
    public function index(){
        
        $user = Auth::user();

        return view('edit_profile',array(
            'user' => $user
        ));;
    }
}
