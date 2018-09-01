@extends('layouts.side_bar')

@section('content_chat')
    <div class="chat_box">
        <header class="chat_box__header">
            <h5>Channel Name</h5>
            <a href="#">fav</a>&nbsp;|&nbsp;
            <a href="#">participants</a>&nbsp;|&nbsp;
            <a href="#">channel Purpose</a>
        </header>
        <hr>
        <article class="chat_box__article">
            
            <div class="mesgs">
                <div class="msg_history">

                    {{-- loop on msgs --}}
                    <div class="incoming_msg">
                        <div class="incoming_msg_img"> 
                            <img src="https://i0.wp.com/dev.slack.com/img/avatars/ava_0010-512.v1443724322.png?ssl=1" alt="sunil"> 
                        </div>
                        <div class="received_msg">
                            <header class="received_msg__header">
                                <span class="time_date"> 11:01 AM    |    Today</span>
                                <h5>Sender Name</h5>
                            </header>
                            <div class="received_withd_msg">
                                <p>We work directly with our designers and suppliers,
                                    and sell direct to you, which means quality, exclusive
                                    products, at a price anyone can afford.</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- End loop --}}

                </div>
            </div>
                    
        </article>
        <footer class="chat_box__footer">
            <input class="input_msg" placeholder="Enter message here..."/>
        </footer>
    </div>
@endsection
