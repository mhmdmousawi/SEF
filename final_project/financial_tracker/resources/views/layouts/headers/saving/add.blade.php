@extends('layouts.headers.main')

@section('content')

<nav class="navbar navbar-inverse fixed-top navbar-expand-lg">
        <div class="container">
            <div class="nav navbar-nav navbar-left">
                <a class="navbar-brand"></a>
            </div>
    
            <ul class="nav navbar-nav navbar-center">
                <li class="navbar-brand">Adding Saving</li>&nbsp;&nbsp;&nbsp;
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a class="navbar-brand"  href="{{config('app.url')}}/dashboard/overview">Cancel</a>
                </li>
            </ul>
        </div>
    </nav>

<div class="container">
    @yield('content_add')
</div>
@endsection