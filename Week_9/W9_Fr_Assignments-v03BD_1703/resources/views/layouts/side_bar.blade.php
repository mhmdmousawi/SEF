@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">Side Bar</div>

                <div class="card-body">
                    <div class="side_bar">
                        <header class="side_bar__header">
                            <h2>{{ config('app.name', 'Laravel') }}</h2>
                            <div class="status status-active"></div>
                            <div class="header__name">
                                <p>{{$profile->display_name}}<p>
                            </div>
                        </header>
                        <hr>
                        <div class="side_bar__channels">
                            <header class="channel__title">
                                <a href="#" class="btn-add"><p>+</p></a>
                                <h4>Channels</h4>
                            </header>
                            <article class="channel__names">
                                @foreach($profile->channels as $channel)
                                @if($channel->private)   
                                    <div class="private-status private-status-on"></div>
                                @else
                                    <div class="private-status"></div>
                                @endif
                                    <div class="channel_name">
                                        <a href="#"><p>{{$channel->name}}</p></a>
                                    </div>
                                @endforeach
                            </article>
                            
                        </div>
                        <hr>    
                        <div class="side_bar__dm">
                            <header class="channel__title">
                                <a href="#" class="btn-add"><p>+</p></a>
                                <h4>Direct Messages</h4>
                            </header>
                            <article class="dm__names">
                                @foreach($profile->friends as $friend)
                                    <div class="status"></div>
                                    <div class="dm_name">
                                        <a href="#"><p>{{$friend->display_name}}</p></a>
                                    </div>
                                @endforeach
                            </article>
                        </div>                    
                    </div>
                    @yield('content_chat')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
