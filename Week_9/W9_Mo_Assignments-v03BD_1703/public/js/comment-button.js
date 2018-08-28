var COMMENT = {

    csrf_token: document.getElementsByTagName('meta')[3].getAttribute("content"),
    btns : document.getElementsByClassName('btn-comment'),
    comment : function(post_id){
    
        var that = this;
        let comment_input = document.getElementById("input_"+post_id);
        let comment_content = comment_input.value;

        //to be changed after request
        var comment_count = document.getElementById("comment_count_"+post_id);
        var info__comments = document.getElementById("info__comments_"+post_id);

        if (!comment_content || comment_content == ""){
            console.log("no content");
            return;
        }
        
        let xhr = new XMLHttpRequest();
        let params = 'content='+comment_content+'&post_id='+post_id;

        xhr.open("POST", 'http://localhost/Week_9/W9_Mo_Assignments-v03BD_1703/public/comment', true);
        xhr.setRequestHeader("X-CSRF-Token", this.csrf_token);
        // xhr.setRequestHeader("Content-type", "application/json");
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() { 
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {

                let comments_recieved = JSON.parse(this.responseText);

                comment_count.innerHTML = "<b>"+comments_recieved.length+"</b> comments";
                //info__comments.innerHTML += '<p>'+comments_recieved[0]['content']+'</p>';
                info__comments.innerHTML += '<p><a href="http://localhost/Week_9/W9_Mo_Assignments-v03BD_1703/public/profile/'
                                        + comments_recieved[0]["user_commenting_id"]+'">'
                                        + comments_recieved[0]["username"]+'</a>'
                                        +': '+comments_recieved[0]["content"]+'</p>';
            }
        };
        xhr.send(params);
    },
    init : function(){

        for (let i = 0; i < this.btns.length; i++) {
            let btns = this.btns[i];
            let post_id = btns.getAttribute("data-post_id");
            btns.addEventListener('click',this.comment.bind(this,post_id));
        }
    }
};

window.addEventListener('load',function(){
    var comment = Object.create(COMMENT);
    comment.init();
});


