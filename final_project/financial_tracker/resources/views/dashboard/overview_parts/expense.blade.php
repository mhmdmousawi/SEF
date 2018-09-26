

<h3>Top 10 Expenses</h3>
<input type='button' name="doughnut" id="chart_pie_expense" value="Doughnut"/>
<input type='button' name="bar" id="chart_bar_expense" value="Bar"/>
<div class="statistics_expense">
    <div id="chart_div_expense">
        <canvas id="chart_canvas_expense"></canvas>
    </div>
    <p type="hidden" id="no_data_expense" value="No Data to Display">No Data to Display</p>
    <input type="hidden" id="stat_lables_expense" value="{{ implode(',', $user->stat_categories_info_expense[0] )}}"/>
    <input type="hidden" id="stat_data_expense" value="{{ implode(',', $user->stat_categories_info_expense[1] )}}"/>
</div>

@foreach(($user->expense_transactions) as $expense)
    <a href="{{config('app.url')}}/edit/transaction?id={{$expense->id}}">
        <h5>Transaction here of id: {{$expense->id}}</h5>
    </a>
    Expense Title: {{$expense->title}}</br>
    Category: {{$expense->category->title}}</br>
    Logo: {{$expense->category->logo->class_name}}</br>
    repeat type:{{$expense->repeat->type}}</br>
    Amount: {{$expense->currency->code}} {{$expense->amount}}</br> 
    </br></br> 
@endforeach