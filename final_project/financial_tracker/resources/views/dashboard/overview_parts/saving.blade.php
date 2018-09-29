
<h3 class="text-center">Top 10 Savings</h3>
<hr>
<div class="topten_div col-xs-12">

     <div class="transactions col-xs-5">
         <p class="col-xs-5 text-info">Transactions:</p>
         @foreach(($user->saving_transactions) as $saving)
             {{-- <a href="{{config('app.url')}}/edit/transaction?id={{$saving->id}}"> --}}
                <div class="col-xs-12 transaction_card">
                    <div class="card-counter primary">
                        <span class="col-xs-2 logo {{$saving->category->logo->class_name}}"></span>
                        <span class="col-xs-5 count-name">{{$saving->title}}</span>
                        <span class="col-xs-5 count-numbers">{{$saving->currency->code}} {{$saving->amount}}</span>
                    </div>
                </div>
            {{-- </a> --}}
         @endforeach
     </div>
     

     <div class="statistics_saving statistics_div col-xs-7 ">
        <div class="btn-group titles titles-dashboard" role="group" aria-label="...">
        <input class="btn btn-default" type='button' name="doughnut" id="chart_pie_saving" value="Doughnut"/>
        <input class="btn btn-default" type='button' name="bar" id="chart_bar_saving" value="Bar"/>
        </div>
        <div id="chart_div_saving">
            <canvas id="chart_canvas_saving"></canvas>
        </div>
        <p type="hidden" id="no_data_saving" value="No Data to Display">No Data to Display</p>
        <input type="hidden" id="stat_lables_saving" value="{{ implode(',', $user->stat_categories_info_saving[0] )}}"/>
        <input type="hidden" id="stat_data_saving" value="{{ implode(',', $user->stat_categories_info_saving[1] )}}"/>
    </div>
    
</div>
