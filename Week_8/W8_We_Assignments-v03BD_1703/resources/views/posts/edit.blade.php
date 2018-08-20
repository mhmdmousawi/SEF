@extends('layouts.app')

@section('content')
    <br>
    <h1>Edit Post</h1>
    <br>
    {!! Form::open(['action' => ['PostsController@update',$post->id], 'method' => 'POST']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', $post->body, [ 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        {{Form::hidden('_method',"PUT")}}
        {{Form::submit('Edit Post', ['class'=>'btn btn-primary'])}}
    {!! Form::close() !!}
       
    
    <hr>
    
@endsection