

<h3>Top 10 Incomes</h3>
<input type='button' name="doughnut" id="chart_pie_income" value="Doughnut"/>
<input type='button' name="bar" id="chart_bar_income" value="Bar"/>
<div class="statistics_income">
    <div id="chart_div_income">
        <canvas id="chart_canvas_income"></canvas>
    </div>
    <p type="hidden" id="no_data_income" value="No Data to Display">No Data to Display</p>
    <input type="hidden" id="stat_lables_income" value="{{ implode(',', $user->stat_categories_info_income[0] )}}"/>
    <input type="hidden" id="stat_data_income" value="{{ implode(',', $user->stat_categories_info_income[1] )}}"/>
</div>
@foreach(($user->income_transactions) as $income)
    <a href="{{config('app.url')}}/edit/transaction?id={{$income->id}}">
        <h5>Transaction here of id: {{$income->id}}</h5>
    </a>
    Income Title: {{$income->title}}</br>
    Category: {{$income->category->title}}</br>
    Logo: {{$income->category->logo->class_name}}</br>
    repeat type:{{$income->repeat->type}}</br>
    Amount: {{$income->currency->code}} {{$income->amount}}</br> 
    </br></br> 
@endforeach