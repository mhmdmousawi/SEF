@extends('layouts.app')

@section('content')
    @if(count($posts)>0)
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4">
                <h3>{{$post->title}}</h3>
                <p>{{$post->body}}</small>
                <img alt= "insta pic" src="{{$post->URL}}"/>
                <p><a class="btn btn-secondary" href="/Week_8/W8_We_Assignments-v03BD_1703/public/posts/{{$post->id}}" role="button">View details &raquo;</a></p>
            </div>
        @endforeach
    </div>
    <hr>
    {{-- {{$posts->links()}} --}}
    @else
        <p>No posts Found</p>
    @endif
@endsection