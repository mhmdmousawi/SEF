<?php

namespace App\Custom;

use Illuminate\Http\Request;
use Auth;
use App\Profile;
use App\Participant;
use App\Channel;


class SideBarInfo 
{
    private $profile;

    public function init(){

        $user = Auth::user();
        $profile = $user->profile;
        
        //get channels in which this profile is a participant in
        $participants = Participant::where('profile_id',$profile->profile_id)
            ->with('channel')->get();
        $i = 0;
        $channel_ids=[];
        foreach($participants as $participant){
            $channel_ids[$i++] = $participant->channel_id;
        }
        $channels = Channel::whereIn('id',$channel_ids)->get();
        $profile->channels = $channels;

        //get profile's friends
        $profile->friends= Profile::all()->take(10);

        $this->setProfile($profile);
    }

    private function setProfile($prof)
    {
        $this->profile = $prof;
    }

    public function getProfile()
    {
        return $this->profile;
    }
}