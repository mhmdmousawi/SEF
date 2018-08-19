@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>Welcome To {{config('app.name','M-Blogs')}}!</h1>
        <p>This is the application "{{config('app.name','M-Blogs')}}" you can post blogs as much as you want! Don't hesitate to get started..</p>
        <p><a class="btn btn-primary btn-lg" href="/login" role="button">Login</a> <a class="btn btn-success btn-lg" href="/register" role="button">Register</a></p>
    </div>
@endsection
