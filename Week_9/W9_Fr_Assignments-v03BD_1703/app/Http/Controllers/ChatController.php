<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\ChatDm;

class ChatController extends Controller
{
    public function channel (Request $request){
        $this->validate($request,[
            'message' =>'required|'
        ]);

        $chat = new Chat;
        $chat->participant_id = $request->user_participant_id;
        $chat->content = $request->message;
        $chat->save();

        return $chat;
    }

    public function direct (Request $request){
        $this->validate($request,[
            'message' =>'required|'
        ]);

        $chat = new ChatDm;
        $chat->sender_id = $request->sender_id;
        $chat->reciever_id = $request->reciever_id;
        $chat->content = $request->message;
        $chat->save();

        return $chat;
    }
}
