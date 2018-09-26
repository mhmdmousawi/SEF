

<h3>Top 10 Savings</h3>
<input type='button' name="doughnut" id="chart_pie_saving" value="Doughnut"/>
<input type='button' name="bar" id="chart_bar_saving" value="Bar"/>
<div class="statistics_saving">
    <div id="chart_div_saving">
        <canvas id="chart_canvas_saving"></canvas>
    </div>
    <p type="hidden" id="no_data_saving" value="No Data to Display">No Data to Display</p>
    <input type="hidden" id="stat_lables_saving" value="{{ implode(',', $user->stat_categories_info_saving[0] )}}"/>
    <input type="hidden" id="stat_data_saving" value="{{ implode(',', $user->stat_categories_info_saving[1] )}}"/>
</div>

@foreach(($user->saving_transactions) as $saving)
    <a href="{{config('app.url')}}/edit/transaction?id={{$saving->id}}">
        <h5>Transaction here of id: {{$saving->id}}</h5>
    </a>
    Saving Title: {{$saving->title}}</br>
    Category: {{$saving->category->title}}</br>
    Logo: {{$saving->category->logo->class_name}}</br>
    repeat type:{{$saving->repeat->type}}</br>
    Amount: {{$saving->currency->code}} {{$saving->amount}}</br> 
    </br></br> 
@endforeach
