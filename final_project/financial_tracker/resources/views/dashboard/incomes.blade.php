@extends('layouts.headers.dashboard')

@section('content_dashboard')

<h3>Incomes</h3>

<input type='button' name="pie" id="chart_pie" value="Pie"/>
<input type='button' name="bar" id="chart_bar" value="Bar"/>
<div class="statistics">
    <div id="chart_div">
        <canvas id="stat_chart"></canvas>
    </div>
    <p type="hidden" id="no_data" value="No Data to Display">No Data to Display</p>
    <input type="hidden" id="stat_lables" value="{{ implode(',', $user->stat_categories_info[0] )}}"/>
    <input type="hidden" id="stat_data" value="{{ implode(',', $user->stat_categories_info[1] )}}"/>
</div>



</br>

Number of Transactions: {{count($user->expanded_incomes)}}</br>

total amount: {{$user->profile->defaultCurrency->code}} {{$user->total_amount}}</br>
daily average: {{$user->profile->defaultCurrency->code}} {{$user->daily_average}}</br>
</br></br> 
{{-- {{$user->incomes}} --}}
@foreach(($user->expanded_incomes) as $income)

    <a href="{{config('app.url')}}/edit/transaction?id={{$income->id}}">
        <h5>transaction here of id: {{$income->id}}</h5>
    </a>
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
