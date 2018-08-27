<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
//use App\Http\Request;
use Auth;
use App\User;
use App\Picture;
use App\Post;
use App\Like;
use App\Comment;
use App\Follow;
use DB;

class ProfileController extends Controller
{
    public function index($user_id)
    {
        $user_logged_in = Auth::user();
        $user = User::where('id',$user_id)->get()->first();
        
        $is_follower = DB::table('follows')
                            ->where('user_id_following',$user_logged_in->id)
                            ->where('user_id_followed',$user->id)
                            ->exists();

        $ppicture = Picture::where('user_id',$user->id )
                            ->where('URL', 'like','profile_picture%')
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->first();
        //add condition on deleted posts later
        $posts = Post::where('user_id',$user->id)->get();

        //link user info
        $user_followers = Follow::where('user_id_followed',$user->id)->get();
        $user_following = Follow::where('user_id_following',$user->id)->get();
        $user->followers = $user_followers;
        $user->following =  $user_following;
        $user->visible = false;
        

        //assign defauls img if there is no profile pic
        if($ppicture){
            $profile_pic = $ppicture;
            $profile_pic->source = $user->id."/".$ppicture->URL;
        }else{
            $profile_pic =  new Picture;
            $profile_pic->source = "default.png";
        }

        //link profile_pic to ther user
        $user->profile_pic = $profile_pic;

        //show full access if ..
        if( $user == $user_logged_in || $user->private == false || $is_follower ){
            
            $user->visible = true;

            //get all info needed of posts
            if(count($posts)>0){
                foreach($posts as $post){
                    
                    //get picture of the post
                    $post_pic = Picture::where('id',$post->picture_id )->get()->first();
                    $post->pic = $post_pic;

                    //get likes of the post
                    $post_likes = Like::where('post_id',$post->id)->get();

                    //get like user's username
                    foreach($post_likes as $like){
                        $user_liking = User::where('id',$like->user_liking_id)->get()->first();
                        $like->username  = $user_liking->username;
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
            
            
        }

        //link posts to user
        $user->posts = $posts;
        
        
        return view("profile",array(
            'user' => $user
        ));
    }
}
