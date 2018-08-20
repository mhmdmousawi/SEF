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
    <a href="{{config('app.url')}}/posts/{{$post->id}}/edit" class="btn btn-outline-primary float-left">Edit Post</a>
    <br><br>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user}}</small>
    <hr>
    
    
@endsection