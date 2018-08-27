<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Picture;
use App\Follow;
use App\Post;
use App\Like;
use App\Comment;
use App\User;
use Auth;

class FeedController extends Controller
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
        $followed_users= Follow::select('user_id_followed')->where('user_id_following',$user->id)->get();

        $i = 0;
        foreach($followed_users as $followed_user){
            $users_ids[$i++] =  $followed_user->user_id_followed;
        }
        $users_ids[$i] = $user->id;


        $posts = Post::whereIn('user_id',$users_ids)
                            ->orderBy('created_at',"DESC")
                            ->get();
        
        //get all info needed of posts
        if(count($posts)>0){
            foreach($posts as $post){
                
                //by default post is not liked
                $post->liked = false;

                //get user of this post
                $post_user = User::where('id',$post->user_id)->get()->first();
                $post->user = $post_user;

                //get picture of the post
                $post_pic = Picture::where('id',$post->picture_id )->get()->first();
                $post->pic = $post_pic;

                //get likes of the post
                $post_likes = Like::where('post_id',$post->id)->get();

                //get like user's username
                foreach($post_likes as $like){
                    $users_liking = User::where('id',$like->user_liking_id)->get();

                    foreach($users_liking as $user_liking){
                        $like->user_id = $user_liking->id;
                        $like->username = $user_liking->username;

                        //check if user has liked that post
                        if($like->user_id == $user->id){
                            $post->liked = true;
                        }
                    }
                }

                $post->likes = $post_likes;

                //get comments of the post
                $post_comments = Comment::where('post_id',$post->id)->get();
                
                //get commenting user's username
                foreach($post_comments as $comment){
                    $user_commenting = User::where('id',$comment->user_commenting_id)->get()->first();
                    $comment->username  = $user_commenting->username;
                }
                $post->comments = $post_comments;
            }
        }
        return view("feed",array(
            'user' => $user,
            'posts' => $posts
        ));
    }
}
