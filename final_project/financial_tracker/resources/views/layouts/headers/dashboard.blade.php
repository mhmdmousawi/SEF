
        
@extends('layouts.headers.main')

@section('content')

<nav class="navbar navbar-inverse fixed-top navbar-expand-lg">
    <div class="container">
        <div class="nav navbar-nav navbar-left">
            <a class="navbar-brand" href="{{config('app.url')}}/profile"><span class="glyphicon glyphicon-user"></span> Profile</a>
        </div>

        <ul class="nav navbar-nav navbar-center">
                {{-- class= "active" --}}
            <li ><a class="navbar-brand" href="{{config('app.url')}}/dashboard/overview">Dashboard</a></li>&nbsp;&nbsp;&nbsp;
            <li class="nav-item dropdown show ">
                <a class="nav-link dropdown-toggle navbar-brand" href="https://example.com" 
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
            <li>
                <a class="navbar-brand"  href="#" data-toggle="modal" data-target="#time_filter_modal">
                <span class="glyphicon glyphicon-calendar"></span> Calender
                </a>
            </li>
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
                    <h4 class="modal-title"> Dashboard Type: {{ $dashboard_type }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form action="{{config('app.url')}}/dashboard/change/filter" method="POST">
                    @csrf

                    <div class="modal-body">
                        <p>Choose the date you would like to represent the date in, and the type of presentation: </p>
                        <input type="text" name="type_filter" value="{{Session::get('time_filter')['type_filter']}}"/>
                        <input type="text" name="date_filter" value="{{Session::get('time_filter')['date_filter']}}"/>
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

    <div class="dashboard_nav">
        <a href="{{config('app.url')}}/dashboard/overview" >Overview </a> |
        <a href="{{config('app.url')}}/dashboard/incomes" >Incomes </a> |
        <a href="{{config('app.url')}}/dashboard/expenses" >Expenses </a> |
        <a href="{{config('app.url')}}/dashboard/savings" >Savings </a> 
    </div>
    <div class="time_filter_info">
        <p>This is a {{Session::get('time_filter')['type_filter']}} representation</p>
    </div>
    
    @yield('content_dashboard')

</div>
@endsection

