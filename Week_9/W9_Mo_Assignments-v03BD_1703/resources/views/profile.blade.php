@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        {{-- FOR PROFILE DISPLAY --}}
        <div class="col-md-8">
            <img value="{{$user->profile_pic_source}}" src="{{config('app.url')}}/uploads/users/{{$user->profile_pic->source}}"/>
            <h2>Profile username: {{$user->username}}</h2>
            <h2>Post Num: {{$user->posts->count()}}</h2>
            <h2>Followers Num: {{$user->followers->count()}}</h2>
            <h2>Following Num: {{$user->following->count()}}</h2>
            @if($user->is_profile)
                <form enctype="multipart/form-data" action="{{config('app.url')}}/uploadProfilePicture" method="POST">
                    <lable>Update Proflile Picture</lable>
                    <input type="file" name="profile_pic">
                    @if ($errors->has('profile_pic'))
                        <span role="alert">
                            <strong>{{ $errors->first('profile_pic') }}</strong>
                        </span>
                    @endif
                    <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                    <input type="submit" class="btn btn-sm btn-primary" value="Update Profile Picture">
                </form>
                <br>
                
            @else
                @if($user->is_follower)
                    <form enctype="multipart/form-data" action="{{config('app.url')}}/unfollow/{{$user->id}}" method="POST">
                        <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                        <input type="submit" class="btn btn-sm btn-primary" value="Unfollow">
                    </form>
                @else
                    <form enctype="multipart/form-data" action="{{config('app.url')}}/follow/{{$user->id}}" method="POST">
                        <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                        <input type="submit" class="btn btn-sm btn-primary" value="Follow">
                    </form>
                @endif
            @endif
            
        </div>

        {{-- FOR POSTS DISPLAY --}}
        <div class="col-md-8 posts_container">
            @if($user->visible)
                @foreach($user->posts as $post)
                    <div class="post one">
                        <a href ='{{config('app.url')}}/profile/{{$post->user->id}}' >{{$post->user->username}}</a>
                        <p id="like_count_{{$post->id}}">Likes: {{$post->likes->count()}}</p>
                        <p>comments: {{$post->comments->count()}}</p>
                        @foreach($post->comments as $comment)
                            <p>{{$comment->username}}: {{$comment->content}}</p>
                        @endforeach
                        <img value="{{$post->pic->URL}}" src="{{config('app.url')}}/uploads/users/{{$user->id}}/posts/{{$post->pic->URL}}"/>
                        {{-- FOR LIKING POST --}}
                        @if(!$post->liked)

                            <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                            <button class="btn-like not_liked" data-btn_type= "like_btn" data-post_id= "{{$post->id}}" >Like</button>
                        @else
                            <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                            <button class="btn-like liked" data-btn_type= "like_btn" data-post_id= "{{$post->id}}" >Unlike</button>
                        @endif
                    </div>
                @endforeach
            @else
                <p>No Posts to display</p>
            @endif
        </div>
    </div>
</div>

<script src="js/like-button.js"></script>
@endsection
