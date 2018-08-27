@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- FOR POSTS DISPLAY --}}
        <div class="col-md-8 posts_container">
                <style>
                        .liked{
                            background-color: red;
                        }
                        .not_liked{
                            background-color: gray;
                        }
                    </style>
            @foreach($posts as $post)
                <div class="post one">
                    <a href ='{{config('app.url')}}/profile/{{$post->user->id}}' >{{$post->user->username}}</a>
                    <p>likes: {{$post->likes->count()}}</p>
                    <p>comments: {{$post->comments->count()}}</p>
                    @foreach($post->comments as $comment)
                        <p>{{$comment->username}}: {{$comment->content}}</p>
                    @endforeach
                    <img value="{{$post->pic->URL}}" src="{{config('app.url')}}/uploads/users/{{$post->user->id}}/posts/{{$post->pic->URL}}"/>
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
        </div>
    </div>
</div>

<script src="js/like-button.js"></script>
@endsection