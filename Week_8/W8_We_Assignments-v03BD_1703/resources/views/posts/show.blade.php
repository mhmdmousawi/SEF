@extends('layouts.app')

@section('content')
    <a href="{{config('app.url')}}/posts" class="btn btn-outline-primary float-right">Go Back</a>
    <br>
    <h1>{{$post->title}}</h1>
    <br><br>
    <div>
        {{$post->body}}
    </div>
    <br>
    <div class="btn-group">
        <a href="{{config('app.url')}}/posts/{{$post->id}}/edit" class="btn btn-outline-primary float-left">Edit Post</a>

        {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
        {!!Form::close()!!}
    </div>
    
    <br><br>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user}}</small>
    <hr>
    
    
@endsection