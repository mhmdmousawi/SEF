
@extends('layouts.headers.profile')

@section('content_profile')

<p class="text-center text-muter">To configure your profile, simply click on the edit button above!</p>
<hr>

<form class="form-virtical ">
    <div class="form-group text-center">
        <label class="control-label col-xs-4 text-info" for="username">Username</label>
        <label class="control-label col-xs-4 text-info" for="password">Password</label>
        <label class="control-label col-xs-4 text-info" for="defaultCurrency">Base Currency</label>
    </div>
    
    <div class="form-group text-center">
        <p class="col-xs-4 text-secondary" for="username">{{$user->profile->username}}</p>
        <p class="col-xs-4 text-secondary" for="passwword">********</p>
        <p class="col-xs-4 text-secondary" for="">{{$user->profile->defaultCurrency->code}}</p>
    </div>  
</form>

@endsection
