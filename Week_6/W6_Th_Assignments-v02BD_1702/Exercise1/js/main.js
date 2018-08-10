
var APP =  {

    correct_num : 248410397744610,
    charlist : "abcdefghijklmnopqrstuvwxyz",
    hint : document.getElementById("hint"),
    btn_get_password : document.getElementById("btn_get_password"),
    btn_submit : document.getElementById("btn_submit"),
    input_password : document.getElementById("input_password"),
    correct_pass : function(number)
    { 
        let char__num_set = [];
        let pass = "";

        while(number != 0){

            if(number%17 != 0){
                let charecter_num = number%17;
                char__num_set.push(charecter_num);

                number -= charecter_num;
                number /=17;
            }
        }

        for (var i = char__num_set.length - 1; i >= 0 ; i--) {
            pass += this.charlist.charAt(char__num_set[i]-1);
        }

        return pass;
    },
    displayHint : function()
    {
        this.hint.innerHTML = "The password is: " + this.correct_pass(this.correct_num);
    },
    checkPass: function()
    {   
        let password = this.input_password.value;
        let total = 0;
        for (let i = 0; i < password.length; i++) {
            let countone = password.charAt(i);
            let counttwo = (this.charlist.indexOf(countone));
            counttwo++;
            total *= 17;
            total += counttwo;
        }

        if (total == 248410397744610) { 
            setTimeout("location.replace('index.php?password=" + password + "' ) ; ", 0)
        } else {
            alert("Sorry, but the password was incorrect.");
        }
    },
    init : function()
    { 
        this.btn_get_password.addEventListener('click',function(){this.displayHint();}.bind(this)),
        this.btn_submit.addEventListener("click",function(){this.checkPass();}.bind(this))
       
    }
};
var app = Object.create(APP);
app.init();
