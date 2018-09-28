@extends('layouts.headers.transaction.add')

<script src="{{ asset('js/transaction/adding/type.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/category.js') }}" defer></script>
<script src="{{ asset('js/transaction/adding/repeat.js') }}" defer></script>

@section('content_add')

@include('transaction.inc.category_modal')

<div class="row" >
    <div class="btn-group titles" role="group" aria-label="...">
        <button type="button" id="title_income" class="btn btn-default  active" >Income</button>
        <button type="button" id="title_expense" class="btn btn-default ">Expense</button>
    </div>
</div>

<form class="form-horizontal" action="{{config('app.url')}}/add/transaction/create" method="POST">
    @csrf
    
    <input type="hidden" id="type_input" name="type" value="income"/>

    <hr>
    
    <div class="form-group">
        <label class="control-label col-xs-4" for="amount">Amount:</label>
        <div class="col-xs-3">
            <input type="number" name='amount' placeholder="0.00" class=" form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" value="{{ old('amount') }}"required/>
        </div>
        <div class="col-xs-1">
            <select class="custom-select form-control form-control-lg" style="height:35px"  name="currency_id" >
                @foreach($currencies as $currency)
                    @if($currency->id == $user->profile->defaultCurrency->id )
                        <option value="{{ $currency->id }}" selected>{{$currency->code}}</option>
                    @else
                        <option value="{{ $currency->id }}" >{{$currency->code}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group" data-toggle="modal" data-target="#category_choosing_modal">
        <label class="control-label col-xs-4" for="category">Category:</label>
        <div id="category_chosen_div">
            <div class="col-xs-4">
                <p class="col-xs-10" id="category_chosen_id">Click to choose your category  &nbsp;&nbsp;</p>
                <span class="col-xs-2 glyphicon glyphicon-piggy-bank" style="font-size:30px"></span>
                <input type='hidden' name='category_id' value=""/>
            </div>
        </div>
    </div>
        
    <hr>
    <div class="form-group">
    <label class="control-label col-xs-4" for="title">Title:</label>
        <div class="col-xs-4">
            <input type='text' name='title' placeholder="Title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" required/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-4" for="description">Description:</label>
        <div class="col-xs-4">
            <textarea rows="2" name='description' placeholder="Description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}">
            </textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-4" for="start_date">Start Date:</label>
        <div class="col-xs-4">
            <input type='date' name='start_date' class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}" required/>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label col-xs-4" for="repeat">Repeat:</label>
        <div class="col-xs-4">
            <select class="form-control" style="height: 35px" id="repeat_select" name="repeat_id" >
                @foreach($repeats as $repeat)
                    @if($repeat->type == "fixed")
                        <option value="{{ $repeat->id }}" >Off</option>
                    @else
                        <option value="{{ $repeat->id }}" >{{$repeat->type}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div id="end_date_div" class="form-group" style='display:none'>
        <label class="control-label col-xs-4" for="end_date">End Date:</label>
        <div class="col-xs-4">
            <input type='date' name='end_date' class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') }}"/><br>
        </div>
    </div>
    
   <hr>
    <div class="form-group">  
        <label class="control-label col-xs-5" for="empty"></label>      
        <div class="col-xs-4" >
            <input class="btn btn-default" type="submit" value="Add">
        </div>
    </div>
</form>


@endsection