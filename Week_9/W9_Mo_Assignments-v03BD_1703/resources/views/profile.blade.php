@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
        {{-- FOR PROFILE DISPLAY --}}
        <div class="col-md-8">
            <img value="{{$profile_pic->source}}" src="uploads/users/{{$profile_pic->source}}"/>
            <h2>{{$user->username}}'s Profile</h2>
            <form enctype="multipart/form-data" action="{{config('app.url')}}/uploadProfilePicture" method="POST">
                <lable>Update Proflile Picture</lable>
                <input type="file" name="profile_pic">
                @if ($errors->has('profile_pic'))
                    <span role="alert">
                        <strong>{{ $errors->first('profile_pic') }}</strong>
                    </span>
                @endif
                <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                <input type="submit" class="btn btn-sm btn-primary" value="Update Profile Picture">
            </form>
            <br>
            <form enctype="multipart/form-data" action="{{config('app.url')}}/uploadPostPicture" method="POST">
                <lable>Update Proflile Picture</lable>
                <input type="file" name="post_pic">
                @if ($errors->has('post_pic'))
                    <span role="alert">
                        <strong>{{ $errors->first('post_pic') }}</strong>
                    </span>
                @endif
                <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                <input type="submit" class="btn btn-sm btn-primary" value="Add Post Picture">
            </form>
        </div>

        {{-- FOR POSTS DISPLAY --}}
        <div class="col-md-8">
            @foreach($posts as $post)
                <h2>POST HERE</h2>
                <img value="{{$post->pic->URL}}" src="uploads/users/{{$user->id}}/posts/{{$post->pic->URL}}"/>
            @endforeach
        </div>
    </div>
</div>
@endsection
