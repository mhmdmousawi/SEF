@extends('layouts.headers.dashboard')
<script src="{{ asset('js/charts.js') }}" defer></script>

@section('content_dashboard')

<hr>
<h2 class="text-center">Incomes</h2>
<form class="form-virtical ">
    <div class="form-group text-center">
        <label class="control-label col-xs-4 text-info" for="">Num of Incomes</label>
        <label class="control-label col-xs-4 text-info" for="">Total Amount</label>
        <label class="control-label col-xs-4 text-info" for="">Daily Average</label>
    </div>
    
    <div class="form-group text-center">
        <p class="col-xs-4 text-secondary" for="">{{count($user->expanded_transactions)}}</p>
        <p class="col-xs-4 text-secondary" for="">{{$user->profile->defaultCurrency->code}} {{round($user->total_amount,2)}}</p>
        <p class="col-xs-4 text-secondary" for="">{{$user->profile->defaultCurrency->code}} {{round($user->daily_average,2)}}</p>
    </div>  
</form>
<br><br><hr>

<div class="statistics_div_big col-xs-8 col-xs-offset-2">
    <div class="btn-group titles titles-dashboard" role="group" aria-label="...">
        <input class="btn btn-default" type='button' name="pie" id="chart_pie" value="Pie"/>
        <input class="btn btn-default" type='button' name="bar" id="chart_bar" value="Bar"/>
    </div>
    <div id="chart_div">
        <canvas id="chart_canvas"></canvas>
    </div>
    <p type="hidden" id="no_data" value="No Data to Display">No Data to Display</p>
    <input type="hidden" id="stat_lables" value="{{ implode(',', $user->stat_categories_info[0] )}}"/>
    <input type="hidden" id="stat_data" value="{{ implode(',', $user->stat_categories_info[1] )}}"/>
</div>

<div class="transactions col-xs-8 col-xs-offset-2">
    <p class="col-xs-5 text-info">Transactions:</p>
    @foreach(($user->expanded_transactions) as $income)
        <a href="{{config('app.url')}}/edit/transaction?id={{$income->id}}">
            <div class="col-xs-12 transaction_card_big">
                <div class="card-counter primary">
                    <div class="col-xs-5">
                        <span class="col-xs-12 count-name"><b>Title:</b> {{$income->title}}</span>
                        <span class="col-xs-12 count-name"><b>Category:</b> {{$income->category->title}}</span>                        
                        <span class="col-xs-12 count-name"><b>Date:</b> {{$income->start_date}}</span>
                    </div>
                    <div class="col-xs-3">
                        <span class="col-xs-12 logo-big {{$income->category->logo->class_name}}"></span>
                    </div>
                    <div class="col-xs-4">
                        <span class="col-xs-12 count-numbers">{{$income->currency->code}} <strong>{{$income->amount}}</strong></span>
                        <span class="col-xs-12 count-numbers"> % {{$income->percentage}}</span>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>

@endsection
