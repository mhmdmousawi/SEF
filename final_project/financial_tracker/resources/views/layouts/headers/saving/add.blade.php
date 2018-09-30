@extends('layouts.headers.main')

@section('content')

<nav class="navbar app_color_default fixed-top navbar-expand-lg">
        <div class="container">
            <div class="nav navbar-nav navbar-left">
                <a class="navbar-brand"></a>
            </div>
    
            <ul class="nav navbar-nav navbar-center">
                <li class="navbar-brand text-light">Adding Saving</li>&nbsp;&nbsp;&nbsp;
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <a class="navbar-brand text-light"  href="{{config('app.url')}}/dashboard/overview">Cancel</a>
            </ul>
        </div>
    </nav>

<div class="container">
    @yield('content_add')
</div>
@endsection