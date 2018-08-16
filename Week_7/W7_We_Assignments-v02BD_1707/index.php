<?php



if(isset($_GET["submit"])){
    if((isset($_GET["input_url"]) && !empty($_GET["input_url"]))){
        //$input_url = $_GET["input_url"];
        $input_url = "https://medium.freecodecamp.org/the-art-of-computer-programming-by-donald-knuth-82e275c8764f";
        $page_content = proxy($input_url);
    }
}
function proxy($URL)
{
    $json = file_get_contents($URL);
    $data = json_encode($json);
    return $data;
}   

function proxy_with_header($URL){
    // Create a stream
    $opts = array(
        'http'=>array(
        'method'=>"GET",
        'header'=>  "X-AYLIEN-TextAPI-Application-Key: 453de889d0cffd85e85692291f960d5a\r\n" .
                    "X-AYLIEN-TextAPI-Application-ID: 1d6d671b\r\n" .
                    "Accept: application/json\r\n" .
                    "url: https://medium.freecodecamp.org/the-art-of-computer-programming-by-donald-knuth-82e275c8764f\r\n".
                    "sentences_number : 10 ".
                    "language : en"
        )
    );
    
    $context = stream_context_create($opts);
    
    // Open the file using the HTTP headers set above
    $file = file_get_contents($URL, false, $context);
    return json_encode($file);
}

?>

<script type="text/javascript">

    var page_content = <?php echo $page_content ?>;

</script>

<script src="js/main.js"></script>