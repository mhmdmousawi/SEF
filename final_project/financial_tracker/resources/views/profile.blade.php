
@extends('layouts.headers.profile')

@section('content_profile')

<h1>Profile Configuration for User: {{$user->profile->username}}</h1>
<br>

<h3>Username: {{$user->profile->username}}</h3> 
<h3>Password: *******</h3>
<h3>Default Currency: {{$user->profile->defaultCurrency->code}}</h3> 

@endsection
