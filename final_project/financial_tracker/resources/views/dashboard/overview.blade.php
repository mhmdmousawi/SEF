@extends('layouts.headers.dashboard')
<script src="{{ asset('js/charts_overview.js') }}" defer></script>


@section('content_dashboard')

    <h3>Overview </h3>

    Total: {{$user->balance}} {{$user->profile->defaultCurrency->code}}<br> 
    Money In: {{$user->money_in}} {{$user->profile->defaultCurrency->code}} <br>
    Money Out: -{{$user->money_out}} {{$user->profile->defaultCurrency->code}} </br>
    Savings: {{$user->saving}} {{$user->profile->defaultCurrency->code}} </br>

    @include('dashboard.overview_parts.income')
    @include('dashboard.overview_parts.expense')
    @include('dashboard.overview_parts.saving')

@endsection
