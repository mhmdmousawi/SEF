@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Side Bar</div>

                <div class="side_bar">
                    <header class="side_bar__header">
                        <p>Name: {{$profile->display_name}}<p>
                        <p>Status: Online</p>
                    </header>
                    <div class="side_bar__channels">
                        <p>Channels</p>
                        @foreach($profile->channels as $channel)
                            <p>{{$channel->name}}</p>
                        @endforeach
                    </div>
                    <div class="side_bar__dm">
                            <p>Direct Messages</p>
                            @foreach($profile->friends as $friend)
                                <p>{{$friend->display_name}}</p>
                            @endforeach
                        </div>                    
                </div>
                <div class="card-body">
                    @yield('content_chat')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
