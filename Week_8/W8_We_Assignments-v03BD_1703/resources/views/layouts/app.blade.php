<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name','M-Blogs')}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}"
       
    </head>
    <body>
        @include('inc.navbar')

        <div class="container">
            @include('inc.messages')
            @yield('content')
        </div>
    </body>
</html>
