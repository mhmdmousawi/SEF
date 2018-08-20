@extends('layouts.app')

@section('content')
    <a href="/Week_8/W8_We_Assignments-v03BD_1703/public/posts/" class="btn btn-outline-primary float-right">Go Back</a>
    <h1>{{$post->title}}</h1>
    <br><br>
    <div>
        {{$post->body}}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by{{$post->user}}</small>
    <hr>
    
@endsection