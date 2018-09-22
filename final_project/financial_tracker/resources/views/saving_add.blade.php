@extends('layouts.main_header')

@section('content')

<h3>Add Saving</h3>

<form action="{{config('app.url')}}/add/saving/validate" method="POST">
    @csrf
    <input name='goal_amount' placeholder="Goal Amount"/>
    <input name='amount' placeholder="Amount"/>

    <div class="basic_info">
        <input type='text' name='currency_id' placeholder="currency_id"/>
        <input type='text' name='category_id' placeholder="category_id"/>
    </div>
    <div class="detailed_info">
        <input type='text' name='title' placeholder="title"/>
        <input type='text' name='description' placeholder="description"/>
        <input type='date' name='start_date'/>
        Saving Fequency:<input type='text' name='repeat_id' placeholder="repeat_id"/>
    </div>

    {{-- On Clicking 'Next' we submit form   --}}
    <input type="submit" value="Next">
</form>


@endsection