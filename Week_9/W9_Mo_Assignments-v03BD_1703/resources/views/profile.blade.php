@extends('layouts.app')

@section('content')
<div class="card-header">{{$user->name}}'s profile</div>
    <div class="card-body">
        
        {{-- FOR PROFILE DISPLAY --}}
        <div class="profile_container">
            <header class="container__header">
                <img class="profile_picture" value="{{$user->profile_pic_source}}" src="{{config('app.url')}}/uploads/users/{{$user->profile_pic->source}}"/>
                @if(!$user->is_profile)
                    @if($user->is_follower )
                        <form class="form_follow" enctype="multipart/form-data" action="{{config('app.url')}}/unfollow/{{$user->id}}" method="POST">
                            <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                            <input type="submit" class="btn btn-sm btn-primary btn-follow" value="Unfollow">
                        </form>
                    @else
                        <form class="form_follow" enctype="multipart/form-data" action="{{config('app.url')}}/follow/{{$user->id}}" method="POST">
                            <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                            <input type="submit" class="btn btn-sm btn-primary btn-follow" value="Follow">
                        </form>
                    @endif
                @endif
            </header>
            <div class="profile__info">
                <header class="info__header">
                    <h3>{{$user->username}}</h3>
                    @if($user->is_profile)
                        <a href="{{config('app.url')}}/editProfile" class="btn btn-primary">Edit Profile</a>
                    @endif
                </header>
                <article class="info__article">
                    <h4><b>{{$user->posts->count()}}</b> posts</h4>
                    <h4><b>{{$user->followers->count()}}</b> followers</h4>
                    <h4><b>{{$user->following->count()}}</b> following</h4>
                </article>
            </div>
            {{-- @if($user->is_profile)
                
                <br>
            @endif --}}
            
        </div>
        <hr>

        {{-- FOR POSTS DISPLAY --}}
        <div class="posts_container">
            @if($user->visible)
                @foreach($user->posts as $post)
                    <div class="post">
                        <header class="post__header">
                            <a class="username" href ='{{config('app.url')}}/profile/{{$post->user->id}}' >{{$post->user->username}}</a>
                        </header>
                        <article class="post__article">
                            <img value="{{$post->pic->URL}}" src="{{config('app.url')}}/uploads/users/{{$user->id}}/posts/{{$post->pic->URL}}"/>
                        </article>
                        <footer class="post__footer">
                            <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                            {{-- FOR LIKING POST --}}
                            @if(!$post->liked)
                                <button class="btn-like not_liked" data-btn_type= "like_btn" data-post_id= "{{$post->id}}" >Like</button>
                            @else
                                <button class="btn-like liked" data-btn_type= "like_btn" data-post_id= "{{$post->id}}" >Unlike</button>
                            @endif
                            <button class="btn-comment" data-btn_type= "comment_btn" data-post_id= "{{$post->id}}" >Comment</button>

                            {{-- FOR Comment POST --}}
                            <input id="input_{{$post->id}}" class="input_comment" data-btn_type= "comment_input" data-post_id= "{{$post->id}}" placeholder="Comment.."></input>

                        </footer>
                        <div class="post__info">
                            <p id="like_count_{{$post->id}}"><b>{{$post->likes->count()}}</b> likes</p>
                            <p id="comment_count_{{$post->id}}"><b>{{$post->comments->count()}}</b> comments</p>
                            <div id="info__comments_{{$post->id}}" class="info__comments">
                                @foreach($post->comments as $comment)
                                    <p><a href="{{config('app.url')}}/profile/{{$comment->user_commenting_id}}">{{$comment->username}}</a>: {{$comment->content}}</p>
                                @endforeach
                            </div>
                        </div>
                        
                        
                    </div>
                @endforeach
            @else
                <p>No Posts to display..</p>
            @endif
        </div>
    </div>
</div>

@endsection
