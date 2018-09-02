<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Profile;
use App\Participant;
use App\Channel;
use App\Custom\SideBarInfo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        return view('home')->with('profile',$this->getUserProfile());
    }

    public function getUserProfile()
    {
        //get profile user info for side bar
        $sbi = new SideBarInfo;
        $sbi->init();
        return $sbi->getProfile();
    }
}
