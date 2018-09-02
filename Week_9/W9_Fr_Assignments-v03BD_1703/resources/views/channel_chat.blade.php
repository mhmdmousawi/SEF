@extends('layouts.side_bar')

@section('content_chat')
    <div class="chat_box">
        <header class="chat_box__header">
            <h5>{{$channel->name}}</h5>
            <a href="#">fav</a>&nbsp;|&nbsp;
            <a href="#"><b>{{$channel->participants->count()}}</b> participants</a>&nbsp;|&nbsp;
            <a href="#">{{$channel->purpose}}</a>
        </header>
        <hr>
        <article class="chat_box__article">
            
            <div class="mesgs">
                <div class="msg_history">

                    {{-- loop on msgs --}}
                    @foreach($channel->chats as $chat)
                        <div class="incoming_msg">
                            <div class="incoming_msg_img"> 
                                <img src="https://i0.wp.com/dev.slack.com/img/avatars/ava_0010-512.v1443724322.png?ssl=1" alt="sunil"> 
                            </div>
                            <div class="received_msg">
                                <header class="received_msg__header">
                                    {{-- 11:01 AM    |     --}}
                                    <span class="time_date"> {{$chat->created_at}}</span>
                                    <h5>{{$chat->sender->display_name}}</h5>
                                </header>
                                <div class="received_withd_msg">
                                    <p>{{$chat->content}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- End loop --}}

                </div>
            </div>
                    
        </article>
        <footer class="chat_box__footer">
            <input class="input_msg" placeholder="Enter message here..."/>
        </footer>
    </div>
@endsection
