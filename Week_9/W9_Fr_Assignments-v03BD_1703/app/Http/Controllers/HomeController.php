<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Profile;
use App\Participant;
use App\Channel;

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
        $user = Auth::user();
        $profile = $user->profile;
        $participants = Participant::where('profile_id',$profile->profile_id)
            ->with('channel')->get();
        
        $i = 0;
        foreach($participants as $participant){
            $channel_ids[$i++] = $participant->channel_id;
        }
        $channels = Channel::whereIn('id',$channel_ids)->get();

        $profile->channels = $channels;

        $profile->friends= Profile::all()->take(10);

        //return $profile;
        return view('home')->with('profile',$profile);
    }
}
