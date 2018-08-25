@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        {{-- <img value="{{$picture->URL}}" src="uploads/users/{{$picture->URL}}"/> --}}
            <h2>{{$user->username}}'s Profile</h2
        </div>
    </div>
</div>
@endsection
