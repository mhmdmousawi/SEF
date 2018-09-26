
@extends('layouts.headers.profile')

@section('content_profile')

<h1>Profile Configuration of user {{$user->profile->username}}</h1>

Username: {{$user->profile->username}} <br>
Password: ******* <br>
Default Currency: {{$user->profile->defaultCurrency->code}} <br>

@endsection
