
var APP = {
    // htmlComponent : {
        article_to_sum : document.getElementById("article_to_sum"),
    // },
    article : "",
    page_content : "", 
    setPage_content : function(content){
        this.page_content = content;
        return this;
    },
    setArticle : function() {
        let HTML = document.createElement('html');
        HTML.innerHTML = this.page_content;
        let paragraphs = HTML.getElementsByClassName("graf--p");

        for (let i=0 ; i < paragraphs.length ; i++ ){
            this.article += paragraphs[i].textContent;
        }
        return this;
    },
    displayArticle : function(){
        console.log(this.article);
    },
    init : function (content){
        this.setPage_content(content)
            .setArticle()
            .displayArticle();

    }
}


//var URL = 'https://api.aylien.com/api/v1/summarize';
var URL = 'https://www.googleapis.com/books/v1/volumes?q=isbn:0747532699';

var HttpRequest = new XMLHttpRequest();

HttpRequest.onreadystatechange = function() { 
        if (HttpRequest.readyState == 4 && HttpRequest.status == 200){
            console.log(HttpRequest.responseText);
            // response.sentences.forEach(function(s) {
                // console.log(s);
            //   });
        }
    }

HttpRequest.open( "GET", URL, true ); 

HttpRequest.setRequestHeader('X-AYLIEN-TextAPI-Application-Key','453de889d0cffd85e85692291f960d5a');
HttpRequest.setRequestHeader('X-AYLIEN-TextAPI-Application-ID', '1d6d671b');
HttpRequest.setRequestHeader('Accept', 'application/json');

var params = JSON.stringify({ 
    'url': 'https://medium.freecodecamp.org/the-art-of-computer-programming-by-donald-knuth-82e275c8764f',
    //'text': article,
    'sentences_number':'10',
    'language': 'en'});

HttpRequest.send(params); 





//important for retreiving sentences
// response.sentences.forEach(function(s) {
//     console.log(s);
//   });


