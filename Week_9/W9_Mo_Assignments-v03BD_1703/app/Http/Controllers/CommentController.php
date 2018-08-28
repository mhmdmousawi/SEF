<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\User;
use Auth;

class CommentController extends Controller
{
    public function comment(Request $request){

        $this->validate($request,[
            'content' =>'required',
            'post_id' =>'required'
        ]);
        
        $content = $request->content;
        $post_id = $request->post_id;

        $user_commenting = Auth::user();
        $comment = new Comment;
        $comment->post_id = $post_id;
        $comment->user_commenting_id = $user_commenting->id;
        $comment->content = $content;
        $comment->save();

        $comments = Comment::where('post_id',$post_id)->orderBy('created_at','DESC')->get();

        //get commenting user's username
        foreach($comments as $comment){
            $user_commenting = User::where('id',$comment->user_commenting_id)->get()->first();
            $comment->username  = $user_commenting->username;
        }

        return $comments ;
    }
}
