var ELEMENTS_TYPE = {
    title_income : document.getElementById('title_income'),
    title_expense : document.getElementById('title_expense'),
    type_input : document.getElementById('type_input'),
}

var TYPE = {

    showOnly: function(type){
        ELEMENTS_CAT.category_divs.forEach(category_div => {
            if(category_div.dataset.categoryType == type){
                category_div.style.display = "block";
            }else{
                category_div.style.display = "none";
            }
        });
    },
    resetChosenCategory : function(){
        ELEMENTS_CAT.category_chosen_div.innerHTML = ''
        +'<div id="category_chosen_div" data-toggle="modal" data-target="#category_choosing_modal">'
        +'    <input type="hidden" name="ategory_id" value="1"/>'
        +'    <p id="category_chosen_id">Category: CT'
        +'    <span class="glyphicon glyphicon-calendar"></span></p>'
        +'</div>';
    },
    changeToIncome : function(title_income){

        title_income.style.color = "green";
        ELEMENTS_TYPE.title_expense.style.color = "red";
        ELEMENTS_TYPE.type_input.value = "income";
        this.showOnly("income");
        this.resetChosenCategory();

    },
    changeToExpense :function(title_expense){

        title_expense.style.color = "green";
        ELEMENTS_TYPE.title_income.style.color = "red";
        ELEMENTS_TYPE.type_input.value = "expense";
        this.showOnly("expense");

    },
    addEvents : function(){

    },
    init : function (){
        ELEMENTS_TYPE.title_income.addEventListener('click',this.changeToIncome.bind(this,ELEMENTS_TYPE.title_income));
        ELEMENTS_TYPE.title_expense.addEventListener('click',this.changeToExpense.bind(this,ELEMENTS_TYPE.title_expense));
    }
}

window.addEventListener('load',function(){
    type = Object.create(TYPE);
    type.init(); 
 
});