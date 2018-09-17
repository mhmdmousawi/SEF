@extends('layouts.main_header')

@section('content')

<h3>Add Incomes or Expense</h3>

<form action="{{config('app.url')}}/add/income/details" method="POST">
    @csrf
    <input name='amount' placeholder="$0.00"/>

    <div class="basic_info">
        <input type='text' name='currency_id' value="currency_id"/>
        <input type='text' name='category_id' value="category_id"/>
        <input type='text' name='profile_id' value="{{$user->profile->id}}"/>
        
    </div>
    <div class="detailed_info">
        <input type='text' name='title' value="title"/>
        <input type='text' name='description' value="description"/>
        <input type='date' name='start_date'/>
        <input type='text' name='repeat_id' value="repeat_id"/>
        <input type='date' name='end_date'/>
    </div>

    {{-- On Clicking 'Next' we submit form   --}}
    <input type="submit" value="Next">
</form>


@endsection