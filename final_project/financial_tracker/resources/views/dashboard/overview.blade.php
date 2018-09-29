@extends('layouts.headers.dashboard')
<script src="{{ asset('js/charts_overview.js') }}" defer></script>


@section('content_dashboard')
    
    <form class="form-virtical ">
        <div class="form-group text-center">
            <label class="control-label col-xs-12 text-info text-lg" for="">Total</label>
        </div>
        <div class="form-group text-center">
            <p class="col-xs-12 text-secondary" for="">{{$user->money_in}} {{$user->profile->defaultCurrency->code}}</p>
        </div>  
    </form>
    
    <br><hr>
    
    <form class="form-virtical ">
        <div class="form-group text-center">
            <label class="control-label col-xs-4 text-info" for="">Money In</label>
            <label class="control-label col-xs-4 text-info" for="">Money Out</label>
            <label class="control-label col-xs-4 text-info" for="">Savings</label>
        </div>
        
        <div class="form-group text-center">
            <p class="col-xs-4 text-secondary" for="">{{$user->balance}} {{$user->profile->defaultCurrency->code}}</p>
            <p class="col-xs-4 text-secondary" for=""> -{{$user->money_out}} {{$user->profile->defaultCurrency->code}}</p>
            <p class="col-xs-4 text-secondary" for="">{{$user->saving}} {{$user->profile->defaultCurrency->code}}</p>
        </div>  
    </form>
    <br><br><br><hr>
    
    @include('dashboard.overview_parts.income')
    @include('dashboard.overview_parts.expense')
    @include('dashboard.overview_parts.saving')

@endsection
