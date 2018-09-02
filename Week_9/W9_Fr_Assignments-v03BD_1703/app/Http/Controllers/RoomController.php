<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Profile;
use App\Participant;
use App\Chat;
use App\Channel;
use App\Custom\SideBarInfo;


class RoomController extends Controller
{

    public function getUserProfile()
    {
        //get profile user info for side bar
        $sbi = new SideBarInfo;
        $sbi->init();
        return $sbi->getProfile();
    }

    public function chat($profile_id){
        
        $chat_profile = Profile::where('profile_id',$profile_id)->get()->first();
        
        // return $chat_profile;
        return view('direct_chat',array(
            'chat_profile' => $chat_profile,
            'profile' => $this->getUserProfile()
        ));
    }

    public function channel($channel_id){
        
        $channel = Channel::where('id',$channel_id)->get()->first();
        $channel->participants = Participant::where('channel_id',$channel->id)->get();

        $i = 0;
        foreach ($channel->participants as $participant) {
            $participants_ids[$i++] = $participant->id;
        }
        $participants_ids[$i] = 0;
        
        $channel->chats = Chat::whereIn('participant_id',$participants_ids)->orderBy('created_at','DESC')->take(20)->get();

        // return $channel;
        
        
        // return $channel;
        // $participants = $channel->participant;
        // $chat = Chat::
        // return $participants;
        // return view('channel_chat');
        return view('channel_chat',array(
            'channel' => $channel,
            'profile' => $this->getUserProfile()
        ));
    }
}
