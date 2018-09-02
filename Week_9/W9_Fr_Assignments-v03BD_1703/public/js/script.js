
var MESSAGE = {
    csrf_token : document.getElementsByTagName('meta')[3].getAttribute("content"),
    input_msg : document.getElementById('input_msg'),
    messages_container : document.getElementById('messages_container'),
    INFO : {
        app_url : document.getElementById('app_url').value,
        user_profile_id : document.getElementById('user_profile_id').value,
        user_profile_display_name : document.getElementById('user_profile_display_name').value,
        user_participant_id : '',
        channel_id : '',
        chat_profile_id : '',
        chat_type : document.getElementById('chat_type').value
    },
    setInfo : function(){
        if (this.chat_type == "channel"){
            this.INFO.user_participant_id = document.getElementById('user_participant_id').value;
            this.INFO.channel_id = document.getElementById('channel_id').value;
        }else{
            this.INFO.chat_profile_id = document.getElementById('chat_profile_id').value;
        }
    },
    onkey : function(event){
        if (event.keyCode == 13) {
            this.send();
        }
    },
    send : function(){
        msg = input_msg.value;
        if(msg == "")return;
        
        input_msg.value = "";
        // console.log(msg);
        this.request(msg);
    },
    request : function(message){
        
        var that = this;
        let xhr = new XMLHttpRequest();
        let params = "";
        if(this.INFO.chat_type == "channel"){
            params = 'user_profile_id='+this.INFO.user_profile_id
                    +'&user_participant_id='+this.INFO.user_participant_id
                    +'&message='+message;
        }else{
            params = 'sender_id='+this.INFO.user_profile_id
                    +'&reciever_id='+this.INFO.chat_profile_id
                    +'&message='+message;
        }
        
        if(this.INFO.chat_type == "channel"){
            xhr.open("POST", this.INFO.app_url+'/sendChannel', true);
        }else{
            xhr.open("POST", this.INFO.app_url+'/sendDirect', true);
        }
        xhr.setRequestHeader("X-CSRF-Token", this.csrf_token);
        //xhr.setRequestHeader('Content-Type','application/json');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() { 
            if (this.readyState == XMLHttpRequest.DONE && this.status == 201) {

                let chat = JSON.parse(this.responseText);
                console.log(chat.content);

                // if(authenticated){
                //     //send websocket request
                // }
                // //on recieving websocket responce
                messages_container.innerHTML += '<div class="incoming_msg">'
                +'<div class="incoming_msg_img">'
                +'<img src="https://i0.wp.com/dev.slack.com/img/avatars/ava_0010-512.v1443724322.png?ssl=1" alt="sunil">'
                +'</div>'
                +   '<div class="received_msg">'
                +      '<header class="received_msg__header">'
                +           '<span class="time_date"> '+chat.created_at+'</span>'
                +           '<h5>'+that.INFO.user_profile_display_name+'</h5>'
                +       '</header>'
                +       '<div class="received_withd_msg">'
                +           '<p>'+chat.content+'</p>'
                +       '</div>'
                +   '</div>'
                +'</div>';
                messages_container.scrollTop = messages_container.scrollHeight;
            }
        };
        xhr.send(params);
    },
    init : function(){
        this.messages_container.scrollTop = this.messages_container.scrollHeight;
        this.setInfo();
        this.input_msg.addEventListener('keypress',this.onkey.bind(this));
    }
}

window.addEventListener('load',function(){
    var message = Object.create(MESSAGE);
    message.init();
});