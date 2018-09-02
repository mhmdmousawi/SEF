<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Profile;
use App\Participant;
use App\Chat;
use App\ChatDm;
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
        
        $user_profile = $this->getUserProfile();
        $chat_profile = Profile::where('profile_id',$profile_id)
                                ->get()
                                ->first();

        $chats = ChatDm::where(function($query) use ($chat_profile,$user_profile) {
                            $query->where('reciever_id', $chat_profile->profile_id)
                                ->where('sender_id', $user_profile->profile_id);	
                        })->orWhere(function($query) use ($chat_profile,$user_profile) {
                            $query->where('sender_id', $chat_profile->profile_id)
                                ->where('reciever_id', $user_profile->profile_id);	
                        })->get();

        foreach ($chats as $chat) {
            $sender_profile = Profile::where('profile_id',$chat->sender_id)
                                        ->get()
                                        ->first();
            $chat->sender = $sender_profile;
        }
        return view('direct_chat',array(
            'chats' => $chats,
            'chat_profile' => $chat_profile,
            'profile' => $user_profile
        ));
    }

    public function channel($channel_id){
        
        $user_profile = $this->getUserProfile();
        
        $user_participant_id = Participant::where('profile_id',$user_profile->profile_id)
                                            ->where('channel_id',$channel_id)
                                            ->pluck('id')
                                            ->first();
        $user_profile->participant_id = $user_participant_id;
        $channel = Channel::where('id',$channel_id)->get()->first();
        $channel->participants = Participant::where('channel_id',$channel->id)->get();

        $i = 0;
        foreach ($channel->participants as $participant) {
            $participants_ids[$i++] = $participant->id;
        }
        $participants_ids[$i] = 0;
        
        $channel->chats = Chat::whereIn('participant_id',$participants_ids)
                                ->orderBy('created_at','DESC')
                                ->take(20)
                                ->get();
        
        foreach ($channel->chats as $chat) {

            $sender_participant = Participant::where('id',$chat->participant_id)
                                                ->get()
                                                ->first();
            $sender_profile = Profile::where('profile_id',$sender_participant->profile_id)
                                        ->get()
                                        ->first();
            $chat->sender = $sender_profile;
        }

        return view('channel_chat',array(
            'channel' => $channel,
            'profile' => $user_profile
        ));
    }
}
