@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Side Bar</div>

                <div class="card-body">
                    <div class="side_bar">
                        <header class="side_bar__header">
                            <h2>{{ config('app.name', 'Laravel') }}</h2>
                            <p>Status<p>
                            <p>{{$profile->display_name}}<p>
                        </header>
                        <hr>
                        <div class="side_bar__channels">
                            <header class="channel__title">
                                <h4>Channels</h4>
                                <a class="btn btn-primary btn-sm btn-add">+</a>
                            </header>
                            <article class="channel__names">
                                @foreach($profile->channels as $channel)
                                <div class="channel_name">
                                    <p>{{$channel->name}}</p>
                                </div>
                                @endforeach
                            </article>
                            
                        </div>
                        <hr>    
                        <div class="side_bar__dm">
                            <header class="channel__title">
                                <h4>Direct Messages</h4>
                                <a class="btn btn-primary btn-sm btn-add">+</a>
                            </header>
                            <article class="dm__names">
                                @foreach($profile->friends as $friend)
                                    <div class="dm_name">
                                        <p>{{$friend->display_name}}</p>
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
