@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <form enctype="multipart/form-data" action="{{config('app.url')}}/uploadPostPicture" method="POST">
                <lable>Update Post Picture</lable>
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
</div>

@endsection