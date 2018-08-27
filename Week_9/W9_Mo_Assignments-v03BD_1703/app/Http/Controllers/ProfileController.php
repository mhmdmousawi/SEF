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
    public function profile()
    {
        $user = Auth::user();
        return $this->profile_with_id($user->id);
    }

    public function profile_with_id($user_id)
    {
       
        $user_logged_in = Auth::user();
        $user_profile = User::where('id',$user_id)->get()->first();
        $user = clone $user_profile;
        
        $is_follower = DB::table('follows')
                            ->where('user_id_following',$user_logged_in->id)
                            ->where('user_id_followed',$user->id)
                            ->exists();

        if($is_follower){
            $user->is_follower = true;
        }else{
            $user->is_follower = false;
        }

        if( $user_profile == $user_logged_in){
            $user->is_profile=true;
        }else{
            $user->is_profile=false;
        }

        $ppicture = Picture::where('id',$user->profile_picture_id)->get()->first();

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
        if( $user_profile == $user_logged_in || $user->private == false || $is_follower ){
            
            $user->visible = true;

            //get all info needed of posts
            if(count($posts)>0){
                foreach($posts as $post){
                    
                    //by default post is not liked
                    $post->liked = false;

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
        }
        //link posts to user
        $user->posts = $posts;
        
        // return $user;
        return view("profile",array(
            'user' => $user
        ));
    }
}
