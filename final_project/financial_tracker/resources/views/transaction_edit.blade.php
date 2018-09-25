@extends('layouts.headers.main_header')

@section('content')

<h3>Edit Incomes or Expense</h3>

<form action="{{config('app.url')}}/edit/transaction" method="POST">
    @csrf
    <input type = "hidden" name='id' placeholder="id" value = "{{$transaction->id}}"/>
    <input type = "text" name='amount' placeholder="$0.00" value = "{{$transaction->amount}}"/>
    <input type='text' name='type' placeholder="type" value = "{{$transaction->type}}" readonly/>
    

    <div class="basic_info">
        <input type='text' name='currency_id' placeholder="currency_id" value = "{{$transaction->currency_id}}"/>
        <input type='text' name='category_id' placeholder="category_id" value = "{{$transaction->category->title}}" readonly/>
        {{-- <input type='text' name='profile_id' placeholder="{{$user->profile->id}}"/> --}}
        
    </div>
    <div class="detailed_info">
        <input type='text' name='title' placeholder="title" value = "{{$transaction->title}}"/>
        <input type='text' name='description' placeholder="description" value = "{{$transaction->description}}"/>
        <input type='date' name='start_date' value = "{{$transaction->start_date}}" readonly/>
        <input type='text' name='repeat_id' placeholder="repeat_id" value = "{{$transaction->repeat->type}}" readonly/>
        <input type='date' name='end_date'value = "{{$transaction->end_date}}" readonly/>

        {{-- DO AJAX Call to display start and end accouding to repeat type  --}}
    </div>
    @if($transaction->repeat_id != 1)
        <div class="edit_info">
            {{-- <input type="radio" name="edit_type" value="current" checked> Only this transaction<br> --}}
            <input type="radio" name="edit_type" value="future" checked> All future transactions<br>
            <input type="radio" name="edit_type" value="all"> All transaction<br>
        </div>
    @else
        <div class="edit_info">
            <input type="hidden" name="edit_type" value="all" checked>
        </div>
        
    @endif

    <input type="submit" value="Update">
    <input type="submit" value="Delete">
</form>


@endsection