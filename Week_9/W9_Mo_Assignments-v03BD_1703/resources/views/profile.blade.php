@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <img value="{{$profile_pic->URL}}" src="uploads/users/{{$profile_pic->URL}}"/>
            <h2>{{$user->username}}'s Profile</h2>
            <form enctype="multipart/form-data" action="{{config('app.url')}}/uploadProfilePicture" method="POST">
                <lable>Update Proflile Picture</lable>
                <input type="file" name="profile_pic">
                <input type= "hidden" name="_token" value="{{ csrf_token()}}">
                <input type="submit" class="btn btn-sm btn-primary">
            </form>
        </div>
    </div>
</div>
@endsection
