@extends('layouts.headers.transaction.add')

<script src="{{ asset('js/transaction/adding/type.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/category.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/repeat.js') }}" defer></script>

@section('content_add')

@include('transaction.inc.category_modal')
<h3>Add Incomes or Expense</h3>

<form action="{{config('app.url')}}/add/transaction/create" method="POST">
    @csrf
    
    <h5 class="chosen" id="title_income">Income</h5>
    <h5 class= "" id="title_expense">Expense</h5>
    <input type="hidden" id="type_input" name="type" value="income"/>

    <hr>
    

    @foreach($user->profile->categories as $category)
        <div id="category_chosen_div" data-toggle="modal" data-target="#category_choosing_modal">
            <input type='hidden' name='category_id' value="{{$category->id}}"/>
            <p id="category_chosen_id">Category: {{$category->title}}
            <span class="glyphicon {{$category->logo->class_name}}"></span></p>
        </div>
        @break
    @endforeach
    
    <input type="number" name='amount' placeholder="0.00"/>
    <select name="currency_id" >
        @foreach($currencies as $currency)
            @if($currency->id == $user->profile->defaultCurrency->id )
                <option value="{{ $currency->id }}" selected>{{$currency->code}}</option>
            @else
                <option value="{{ $currency->id }}" >{{$currency->code}}</option>
            @endif
            
        @endforeach
    </select>
    

    <hr>
    Details:
    <div class="detailed_info">
        Title:<input type='text' name='title' placeholder="title"/><br>
        Description:<input type='text' name='description' placeholder="description"/><br>
        Start Date:<input type='date' name='start_date'/><br>
        Repeat:
        <select id="repeat_select" name="repeat_id" >
            @foreach($repeats as $repeat)
                @if($repeat->type == "fixed")
                    <option value="{{ $repeat->id }}" >Off</option>
                @else
                    <option value="{{ $repeat->id }}" >{{$repeat->type}}</option>
                @endif
            @endforeach
        </select>
        <br>

        <div id="end_date_div" style='display:none'>
            End Date:<input type='date' name='end_date'/><br>
        </div>
    </div>

    {{-- On Clicking 'Next' we submit form   --}}
    <input type="submit" value="Add">
</form>


@endsection