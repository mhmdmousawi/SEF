
        
@extends('layouts.headers.main')

@section('content')

<nav class="navbar fixed-top navbar-expand-lg app_color_default">
    <div class="container">
        <div class="nav navbar-nav navbar-left">
            <a class="navbar-brand text-light" href="{{config('app.url')}}/profile"><span class="glyphicon glyphicon-user"></span> Profile</a>
        </div>

        <ul class="nav navbar-nav navbar-center">
                {{-- class= "active" --}}
            {{-- <li > --}}
                <a class="navbar-brand text-light" href="{{config('app.url')}}/dashboard/overview">Dashboard</a>
            {{-- </li>&nbsp;&nbsp;&nbsp; --}}
            <li class="nav-item dropdown show">
                <a class="nav-link  dropdown-toggle navbar-brand text-light"
                    data-toggle="dropdown" aria-expanded="true">
                    {{-- <span class="glyphicon glyphicon-plus-sign"></span>--}}Add
                </a>
                <div class="dropdown-menu" >
                    <a class="dropdown-item" href="{{config('app.url')}}/add/transaction">Transaction</a>
                    <a class="dropdown-item" href="{{config('app.url')}}/add/saving">Saving Plan</a>
                    <a class="dropdown-item" href="#">Smart Plan</a>
                </div>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            {{-- <li> --}}
                <a class="navbar-brand text-light"  href="#" data-toggle="modal" data-target="#time_filter_modal">
                <span class="glyphicon glyphicon-calendar"></span> Calender
                </a>
            {{-- </li> --}}
        </ul>
    </div>
</nav>

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="time_filter_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Dashboard Filter:</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="form-horizontal" action="{{config('app.url')}}/dashboard/change/filter" method="POST">
                    @csrf

                    <div class="modal-body">
                        <p>Choose the date you would like to represent your data in, and the type of presentation: </p>

                        <div class="form-group">
                            <div class="col-xs-3">
                                <select name="type_filter"  class="custom-select form-control form-control-lg" style="height:35px" >
                                    @if(Session::get('time_filter')['type_filter'] == "weekly")
                                        <option value="weekly" selected>Weekly</option>
                                        <option value="monthly" >Monthly</option>
                                        <option value="yearly" >Yearly</option>
                                    @elseif(Session::get('time_filter')['type_filter'] == "monthly")
                                        <option value="weekly" >Weekly</option>
                                        <option value="monthly" selected>Monthly</option>
                                        <option value="yearly" >Yearly</option>
                                    @elseif(Session::get('time_filter')['type_filter'] == "yearly")
                                        <option value="weekly" >Weekly</option>
                                        <option value="monthly" >Monthly</option>
                                        <option value="yearly" selected>Yearly</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <input type="date" class=" form-control" name="date_filter" value="{{Session::get('time_filter')['date_filter']}}"/>                        
                            </div>
                        </div>
                        <input type="hidden" name="dashboard_type" value="{{ $dashboard_type }}"/>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Ok</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row" >
        <div class="btn-group titles titles-dashboard" role="group" aria-label="...">
            <a href="{{config('app.url')}}/dashboard/overview" >
                <button type="button" id="title_income" class="btn btn-default  {{ $dashboard_type == "overview" ? ' active' : '' }}" >Overview</button>
            </a>
            <a href="{{config('app.url')}}/dashboard/incomes" >
                <button type="button" id="title_expense" class="btn btn-default {{ $dashboard_type == "income" ? ' active' : '' }}">Incomes</button>
            </a>
            <a href="{{config('app.url')}}/dashboard/expenses" >
                <button type="button" id="title_expense" class="btn btn-default {{ $dashboard_type == "expense" ? ' active' : '' }}">Expenses</button>
            </a>
            <a href="{{config('app.url')}}/dashboard/savings" >
                <button type="button" id="title_expense" class="btn btn-default {{ $dashboard_type == "saving" ? ' active' : '' }}">Savings</button>
            </a>
        </div>
    </div>

    <hr>
    <div class="text-center text-info ">
        <p>This is a {{Session::get('time_filter')['type_filter']}} representation</p>
    </div>
    
    @yield('content_dashboard')

</div>
@endsection

