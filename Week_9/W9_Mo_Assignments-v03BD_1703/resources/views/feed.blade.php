@extends('layouts.app')

@section('content')

<div class="card-header">Feed</div>
    <div class="card-body">
        {{-- FOR POSTS DISPLAY --}}
        <div class="posts_container">
            @foreach($posts as $post)
                <div class="post">
                    <header class="post__header">
                        <a class="username"  href ='{{config('app.url')}}/profile/{{$post->user->id}}' >{{$post->user->username}}</a>
                    </header>
                    <hr>
                    <article class="post__article">
                        <img value="{{$post->pic->URL}}" src="{{config('app.url')}}/uploads/users/{{$post->user->id}}/posts/{{$post->pic->URL}}"/>
                    </article>
                    <footer class="post__footer">
                        <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                        <input type= "hidden" name="app_url" value="{{ config('app.url')}}">
                        {{-- FOR LIKING POST --}}
                        @if(!$post->liked)
                            <button class="btn-like not_liked" data-btn_type= "like_btn" data-post_id= "{{$post->id}}" >Like</button>
                        @else
                            <button class="btn-like liked" data-btn_type= "like_btn" data-post_id= "{{$post->id}}" >Unlike</button>
                        @endif
                        <button class="btn-comment " data-btn_type= "comment_btn" data-post_id= "{{$post->id}}" >Comment</button>
                        {{-- FOR Comment POST --}}
                        <input id="input_{{$post->id}}" class="input-comment" data-btn_type= "comment_input" data-post_id= "{{$post->id}}" placeholder="Comment.."></input>

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
        </div>
    </div>
</div>

@endsection