@extends('layouts.main_header')

@section('content')

<h3>Add Incomes or Expense</h3>

<form action="{{config('app.url')}}/add/income/create" method="POST">
    @csrf
    <input name='amount' placeholder="$0.00"/>
    <input type='text' name='type' placeholder="type"/>
    

    <div class="basic_info">
        <input type='text' name='currency_id' placeholder="currency_id"/>
        <input type='text' name='category_id' placeholder="category_id"/>
        {{-- <input type='text' name='profile_id' placeholder="{{$user->profile->id}}"/> --}}
        
    </div>
    <div class="detailed_info">
        <input type='text' name='title' placeholder="title"/>
        <input type='text' name='description' placeholder="description"/>
        <input type='date' name='start_date'/>
        <input type='text' name='repeat_id' placeholder="repeat_id"/>
        <input type='date' name='end_date'/>
    </div>

    {{-- On Clicking 'Next' we submit form   --}}
    <input type="submit" value="Next">
</form>


@endsection