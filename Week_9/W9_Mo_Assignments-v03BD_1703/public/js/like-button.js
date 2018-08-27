var LIKE = {

    csrf_token: document.getElementsByTagName('meta')[3].getAttribute("content"),
    btns : document.getElementsByClassName('btn-like'),
    like_or_unlike : function(post_id){
    
        var that = this;
        var my_btn = document.querySelector('button[data-post_id="'+post_id+'"]');
        var like_count = document.getElementById("like_count_"+post_id);
        var post_status = my_btn.getAttribute("class");
        let xhr = new XMLHttpRequest();


        //if it was liked then we want to unlike
        if(post_status=="btn-like liked"){
            xhr.open("POST", 'http://localhost/Week_9/W9_Mo_Assignments-v03BD_1703/public/unlike/'+ post_id, true);
        }else{
            xhr.open("POST", 'http://localhost/Week_9/W9_Mo_Assignments-v03BD_1703/public/like/'+ post_id, true);
        }
        
        xhr.setRequestHeader("X-CSRF-Token", this.csrf_token);
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onreadystatechange = function() { 
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {

                // Request finished. Do processing here.
                let recieved_likes = JSON.parse(this.responseText);

                if(post_status!="btn-like liked"){
                    my_btn.setAttribute("class", 'btn-like liked');
                    my_btn.innerHTML = "Unlike";
                    like_count.innerHTML = "<b>"+recieved_likes.length+"</b> likes";
                }else{
                    my_btn.setAttribute("class", 'btn-like not_liked');
                    my_btn.innerHTML = "Like";
                    like_count.innerHTML = "<b>"+recieved_likes.length+"</b> likes";
                }
            }
        };
        xhr.send();
    },
    init : function(){

        for (let i = 0; i < this.btns.length; i++) {
            let btns = this.btns[i];
            let post_id = btns.getAttribute("data-post_id");
            btns.addEventListener('click',this.like_or_unlike.bind(this,post_id));
        }
    }
};

window.addEventListener('load',function(){
    var like = Object.create(LIKE);
    like.init();
});


