@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- FOR POSTS DISPLAY --}}
        <div class="col-md-8 posts_container">
            @foreach($posts as $post)
                <div class="post one">
                    <h2>{{$post->user->username}}</h2>
                    <p>likes: {{$post->likes->count()}}</p>
                    <p>comments: {{$post->comments->count()}}</p>
                    @foreach($post->comments as $comment)
                        <p>{{$comment->username}}: {{$comment->content}}</p>
                    @endforeach
                    <img value="{{$post->pic->URL}}" src="{{config('app.url')}}/uploads/users/{{$post->user->id}}/posts/{{$post->pic->URL}}"/>
                    {{-- FOR LIKING POST --}}
                    @if(!$post->liked)
                        <form enctype="multipart/form-data" action="{{config('app.url')}}/like/{{$post->id}}" method="POST">
                            <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                            <input type="submit" class="btn btn-sm btn-primary" value="Like">
                        </form>
                    @else
                        <form enctype="multipart/form-data" action="{{config('app.url')}}/unlike/{{$post->id}}" method="POST">
                            <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                            <input type="submit" class="btn btn-sm btn-primary" value="Unlike">
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection