
var MESSAGE = {
    csrf_token : document.getElementsByTagName('meta')[3].getAttribute("content"),
    input_msg : document.getElementById('input_msg'),
    messages_container : document.getElementById('messages_container'),
    INFO : {
        app_url : document.getElementById('app_url').value,
        user_profile_id : document.getElementById('user_profile_id').value,
        user_profile_display_name : document.getElementById('user_profile_display_name').value,
        user_participant_id : document.getElementById('user_participant_id').value,
        channel_id : document.getElementById('channel_id').value
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
        console.log(msg);
        // this.request(msg);
    },
    request : function(message){
        
        let xhr = new XMLHttpRequest();
        let params = 'user_profile_id='+this.INFO.user_profile_id
                    +'&user_participant_id='+this.INFO.user_participant_id
                    +'&message='+message;

        xhr.open("POST", this.INFO.app_url+'/sendChannel', true);
        xhr.setRequestHeader("X-CSRF-Token", this.csrf_token);
        // xhr.setRequestHeader("Content-type", "application/json");
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() { 
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {

                let authenticated = JSON.parse(this.responseText);
                if(authenticated){
                    //send websocket request
                }
                //on recieving websocket responce
                messages_container.innerHTML += '<div class="incoming_msg">'
                +'<div class="incoming_msg_img">'
                +'<img src="https://i0.wp.com/dev.slack.com/img/avatars/ava_0010-512.v1443724322.png?ssl=1" alt="sunil">'
                +'</div>'
                +   '<div class="received_msg">'
                +      '<header class="received_msg__header">'
                +           '<span class="time_date"> '+message_time+'</span>'
                +           '<h5>'+this.INFO.user_profile_display_name+'</h5>'
                +       '</header>'
                +       '<div class="received_withd_msg">'
                +           '<p>'+message+'</p>'
                +       '</div>'
                +   '</div>'
                +'</div>';
            }
        };
        xhr.send(params);
    },
    init : function(){
        this.input_msg.addEventListener('keypress',this.onkey.bind(this));
    }
}

window.addEventListener('load',function(){
    var message = Object.create(MESSAGE);
    message.init();
});