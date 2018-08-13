
var APP =  {
    items_id : 0,
    btn_add : document.getElementById("btn_add"),
    input_title : document.getElementById("input_title"),
    input_desc : document.getElementById("input_desc"),
    items : document.getElementById("items"),
    months : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    days : ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    deleteItem : function(btn){
        btn.parentNode.parentNode.remove();
    },
    addItem : function(){
        let title = this.input_title.value;
        let desc = this.input_desc.value;
        //validate input .. 
        if(title != "" && desc != ""){

            let article__item_div = document.createElement("div");
            article__item_div.id = "item__"+(++this.items_id);
            article__item_div.classList.add("article__item"); 

            let item__content_div = document.createElement("div");
            item__content_div.classList.add("item__content");

            let h2 = document.createElement("h2");
            let title_h2 = this.input_title.value;
            h2.innerHTML = title_h2;

            let p_time = document.createElement("p");
            p_time.classList.add("content__time");

            let date = new Date();
            let time_p = "added: "+
                        this.days[date.getDay()]+ ", " +
                        this.months[date.getMonth()]+" "+
                        date.getDate()+" "+
                        date.getFullYear() + " "+ 
                        date.getHours() + ":" +
                        date.getMinutes();
            p_time.innerHTML = time_p;

            let p_desc = document.createElement("p");
            p_desc.classList.add("content__desc");
            let desc_p = this.input_desc.value;
            p_desc.innerHTML = desc_p;

            let item__delete_div = document.createElement("div");
            item__delete_div.classList.add("item__delete");

            let btn_delete = document.createElement("button");
            btn_delete.id = "btn_"+ this.items_id;
            btn_delete.innerHTML = "X";
            btn_delete.addEventListener('click', function(){this.deleteItem(btn_delete);}.bind(this));

            item__content_div.appendChild(h2);
            item__content_div.appendChild(p_time);
            item__content_div.appendChild(p_desc);
            article__item_div.appendChild(item__content_div);

            item__delete_div.appendChild(btn_delete);
            article__item_div.appendChild(item__delete_div);

            this.items.appendChild(article__item_div);

        }else {
            alert("Please enter whatever..");
        }
    },
    expandArea: function(){
        var heightLimit = 200;
        this.input_desc.style.height = ""; 
        this.input_desc.style.height = Math.min(this.input_desc.scrollHeight, heightLimit) + "px";
    },
    init : function()
    { 
        this.btn_add.addEventListener('click',function(){this.addItem();}.bind(this));
        this.input_desc.addEventListener('input', function(){this.expandArea();}.bind(this));
    }
    
};
var app = Object.create(APP);
app.init();

