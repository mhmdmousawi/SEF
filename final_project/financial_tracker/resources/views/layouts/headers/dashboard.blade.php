<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/charts.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    {{-- Chat.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    

</head>
<body>
        
    <nav class="navbar navbar-inverse fixed-top navbar-expand-lg">
        <div class="container">
            <div class="nav navbar-nav navbar-left">
                <a class="navbar-brand" href="{{config('app.url')}}/profile"><span class="glyphicon glyphicon-user"></span> Profile</a>
            </div>

            <ul class="nav navbar-nav navbar-center">
                <li class= "active"><a class="navbar-brand" href="{{config('app.url')}}/dashboard/overview">Dashboard</a></li>&nbsp;&nbsp;&nbsp;
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
                <li><a class="navbar-brand"  href="#"><span class="glyphicon glyphicon-calendar"></span> Calender</a></li>
            </ul>
        </div>
    </nav> 

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
