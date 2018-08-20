@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome To {{config('app.name','M-Blogs')}}!</h1>
        <p>This is the application "{{config('app.url')}}" you can post blogs as much as you want! Don't hesitate! Get started..</p>
        <br>
        <p><a class="btn btn-outline-primary btn-lg" href="/register" role="button">Register</a></p>
    </div>
@endsection
