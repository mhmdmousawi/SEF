@extends('layouts.headers.dashboard')

@section('content')

<h3>Incomes</h3>

<canvas type="hidden" id="stat_chart"></canvas>
<p type="hidden" id="no_data" value="No Data to Display">No Data to Display</p>
<input type="hidden" id="stat_lables" value="{{ implode(',', $user->stat_categories_info[0] )}}"/>
<input type="hidden" id="stat_data" value="{{ implode(',', $user->stat_categories_info[1] )}}"/>

<input type="hidden" id= "chart_type" value="pie"/>


</br>

Number of Transactions: {{count($user->expanded_incomes)}}</br>

total amount: {{$user->profile->defaultCurrency->code}} {{$user->total_amount}}</br>
daily average: {{$user->profile->defaultCurrency->code}} {{$user->daily_average}}</br>
</br></br> 
{{-- {{$user->incomes}} --}}
@foreach(($user->expanded_incomes) as $income)

    <h5>transaction here</h5>
    Income Title: {{$income->title}}</br>
    Category: {{$income->category->title}}</br>
    Logo: {{$income->category->logo->class_name}}</br>
    repeat type:{{$income->repeat->type}}</br>
    Start Date: {{$income->start_date}}</br>
    Transaction type: {{$income->type}} </br>
    Amount: {{$income->currency->code}} {{$income->amount}}</br> 
    Percentage: %{{$income->percentage}}
    
    </br></br> 

@endforeach
{{-- {{$user->profile->incomes}} --}}

@endsection
