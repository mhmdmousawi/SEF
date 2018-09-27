
var ELEMENTS_VERIFICATION = {
    request_url : document.getElementById('request_url'),

    add_saving_form : document.getElementById('add_saving_form'),
    csrf_token : document.getElementById('csrf_token'),
    goal_amount : document.getElementById('goal_amount'),
    amount : document.getElementById('amount'),
    currency_id : document.getElementById('currency_id'),
    category_id : document.getElementById('category_id'),
    title : document.getElementById('title'),
    description : document.getElementById('description'),
    start_date : document.getElementById('start_date'),
    repeat_id : document.getElementById('repeat_id'),
    verify_bnt : document.getElementById('verify_bnt'),
    validation_result : document.getElementById('validation_result'),


    saving_varification_modal : document.getElementById('saving_varification_modal'),
}

var VERIFICATION = {
    
    showVarificationModal : function(result){
        
        ELEMENTS_VERIFICATION.validation_result.innerHTML =  'This saving is '+result;
        ELEMENTS_VERIFICATION.verify_bnt.click();
    },
    varify : function(){

        const url = ELEMENTS_VERIFICATION.request_url.value;
        let data = new FormData(ELEMENTS_VERIFICATION.add_saving_form);
        let that = this;

        var request = new Request(url, {
            method: 'POST', 
            body: data,
        });

        fetch(request)
        .then(function(response){
            
           return response.json();
        })
        .then(function(data) {
            
            that.showVarificationModal(data.verification);
            
            console.log(data);
            console.log(data.verification);
            
        })
        .catch(function(error) {
            console.log(error);
        });
    },
    init : function (){
        
        ELEMENTS_VERIFICATION.verify_bnt.addEventListener('click',this.varify.bind(this));
        
    }
}

window.addEventListener('load',function(){

    verification = Object.create(VERIFICATION);
    verification.init(); 
 
});