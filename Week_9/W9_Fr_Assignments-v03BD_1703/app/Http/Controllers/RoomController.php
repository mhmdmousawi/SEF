<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Profile;
use App\Participant;
use App\Channel;
use App\Custom\SideBarInfo;


class RoomController extends Controller
{
    public function chat($profile_id){
        
        $sbi = new SideBarInfo;
        $sbi->init();
        $profile = $sbi->getProfile();
        return view('direct_chat')->with('profile',$profile);
        //return view('direct_chat');
    }

    public function channel($channel_id){
        
        // $channel = Channel::find($channel_id);
        // $participants = $channel->participant;
        // return $participants;
        return view('channel_chat');
    }
}
