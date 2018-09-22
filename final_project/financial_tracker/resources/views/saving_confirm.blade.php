@extends('layouts.main_header')

@section('content')

<h3>Validate Saving</h3>

@if($user->saving_validation)
    @if($user->saving_validation == "valid")
        {{-- {{var_dump(Session::get('saving_valid'))}} --}}
        <div>SAVING IS VALID, Confirm or Cancel..</div>
        <form action="{{config('app.url')}}/add/saving/confirm" method="POST">
            @csrf
            <input type="submit" name="confirm" value="Confirm">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    @elseif($user->saving_validation == "invalid")
        <div>THIS SAVING IS NOT VALID, update and try again..</div>
        <button>Back</button>
    @endif
@endif




@endsection