var LIKE = {

    csrf_token: document.getElementsByTagName('meta')[3].getAttribute("content"),
    //btns : document.querySelectorAll('button[data-btn_type="like_btn"]'),
    btns : document.getElementsByClassName('btn-like'),
    //like_btns : document.getElementsByClassName("not_liked"),
    //un_like_btns : document.getElementsByClassName("liked"),
    like_or_unlike : function(post_id){
        

        console.log("event");
        var that = this;
        var my_btn = document.querySelector('button[data-post_id="'+post_id+'"]');
        var post_status = my_btn.getAttribute("class");
        console.log(post_status + " status foo2");
        let xhr = new XMLHttpRequest();


        //if it was liked then we want to unlike
        if(post_status=="btn-like liked"){
            xhr.open("POST", 'http://localhost/Week_9/W9_Mo_Assignments-v03BD_1703/public/unlike/'+ post_id, true);
        }else{
            xhr.open("POST", 'http://localhost/Week_9/W9_Mo_Assignments-v03BD_1703/public/like/'+ post_id, true);
        }
        
        xhr.setRequestHeader("X-CSRF-Token", this.csrf_token);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() { 
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                // Request finished. Do processing here.
                // let my_btn = document.querySelector('button[data-post_id="'+post_id+'"]');

                console.log(post_status + " status");
                if(post_status!="btn-like liked"){
                    my_btn.setAttribute("class", 'btn-like liked');
                    my_btn.innerHTML = "Unlike";
                }else{
                    my_btn.setAttribute("class", 'btn-like not_liked');
                    my_btn.innerHTML = "Like";
                }
            }
        };
        xhr.send();
    },
    like : function(post_id){
        
        var that = this;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", 'http://localhost/Week_9/W9_Mo_Assignments-v03BD_1703/public/like/'+ post_id, true);
        xhr.setRequestHeader("X-CSRF-Token", this.csrf_token);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() { 
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                // Request finished. Do processing here.
                let my_btn = document.querySelector('button[data-post_id="'+post_id+'"]');
                my_btn.setAttribute("class", 'liked');
                my_btn.innerHTML = "Unlike";
                // my_btn.removeEventListener('click',that.like.bind(that,post_id),true);
                // console.log(my_btn);
                //my_btn.addEventListener('click',that.unlike.bind(that,post_id), false);
            }
        };
        xhr.send();
    },
    unlike : function(post_id){

        var that = this;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", 'http://localhost/Week_9/W9_Mo_Assignments-v03BD_1703/public/unlike/'+ post_id, true);
        xhr.setRequestHeader("X-CSRF-Token", this.csrf_token);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() { 
            if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
                // Request finished. Do processing here.
                let my_btn = document.querySelector('button[data-post_id="'+post_id+'"]');
                my_btn.setAttribute("class", 'not_liked');
                my_btn.innerHTML = "Like";
                //my_btn.removeEventListener('click',that.unlike.bind(that,post_id),true);
                //my_btn.addEventListener('click',that.like.bind(that,post_id), false);
                
            }
        };
        xhr.send();
    },
    init : function(){

        console.log(this.btns);
        for (let i = 0; i < this.btns.length; i++) {
            let btns = this.btns[i];
            let post_id = btns.getAttribute("data-post_id");
            // let status = btns.getAttribute("class");
            //console.log(status);
            btns.addEventListener('click',this.like_or_unlike.bind(this,post_id));
        }
        // for (let i = 0; i < this.like_btns.length; i++) {
        //     let like_btns = this.like_btns[i];
        //     let post_id = like_btns.getAttribute("data-post_id");
        //     like_btns.addEventListener('click',this.like.bind(this,post_id));
        // }
        // for (let i = 0; i < this.un_like_btns.length; i++) {
        //     let un_like_btns = this.un_like_btns[i];
        //     let post_id = un_like_btns.getAttribute("data-post_id");
        //     un_like_btns.addEventListener('click',this.unlike.bind(this,post_id));
        // }
    }
};

window.addEventListener('load',function(){
    var like = Object.create(LIKE);
    like.init();
});



// var LIKE = {
//     csrf_token: document.getElementsByTagName('meta')[0].getAttribute("content"),
//     like_buttons: document.getElementsByClassName("like"),    
//     init: function() {
//         for (let i = 0; i < this.like_buttons.length; i++) {
//             let like_button = this.like_buttons[i];
//             let post_id = like_button.getAttribute("data-post_id");
//             like_button.addEventListener('click', this.like.bind(this, post_id));
//         }
//     },    
//     like: function(post_id) {
//         var like_button = document.querySelector('img[data-post_id=\"' + post_id + '\"]');
//         let like_toggle = like_button.getAttribute("data-like_toggle");
//         var new_toggle = (++like_toggle) % 2;        
//         let xhr = new XMLHttpRequest();        
//         xhr.open("POST", '/like_post', true);
//         xhr.setRequestHeader("X-CSRF-Token", this.csrf_token);
//         xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");        
//         xhr.onreadystatechange = function() { //Call a function when the state changes.
//             if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
//                 // Request finished. Do processing here.
//                 like_button.setAttribute("data-like_toggle", new_toggle);
//                 like_button.src = "http://localhost:8000/images/heart_" + new_toggle + ".png";
//             }
//         };        
//         enc_post_id = encodeURIComponent(post_id);
//         enc_like_toggle = encodeURIComponent(new_toggle);
//         xhr.send("post_id=" + enc_post_id + "&like_toggle=" + enc_like_toggle);
//     },
//   };
