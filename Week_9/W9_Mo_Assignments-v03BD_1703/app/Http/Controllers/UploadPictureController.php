<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;

class UploadPictureController extends Controller
{
    public function profile_picture(Request $request)
    {
        //sudo apt-get install php7.2-gd

        if($request->hasFile("profile_pic")){
            $profile_pic = $request->file('profile_pic');
            $file_name = $profile_pic->getClientOriginalName() ;//. $profile_pic->getClientOriginalExtension();
        
            Image::make($profile_pic)
                        ->resize(300,300)
                        ->save( public_path('/uploads/users/'. $file_name ) );
        }

        return redirect('/profile');
    }
}
