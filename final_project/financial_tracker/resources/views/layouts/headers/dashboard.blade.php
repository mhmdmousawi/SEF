
        
@extends('layouts.headers.main_header')

@section('content')
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
                    <p>Some text in the modal.</p>
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
    
    {{-- <div class="container"> --}}
        @yield('content_dashboard')
    {{-- </div> --}}

@endsection

