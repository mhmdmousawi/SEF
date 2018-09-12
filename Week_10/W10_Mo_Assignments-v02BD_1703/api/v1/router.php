<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require __DIR__."/Request.php";
$request = new Request;


if($request->request_uri == "/actor/read"){
    /*
    *   send as get:
    *   returns all actors
    */ 
    $request->get("/actor/read","ActorController@read");
    
}else if( preg_match("#^\/actor\/read\/.*#",$request->request_uri) ){
    /*
    *   send as get; with url fomrat /actor/read/firstName/lastName
    *   the user can send either firstname alone or both
    */
    $request->get_with_var($request->request_uri,"/actor/read/","ActorController@filter_names");

}else if($request->request_uri == "/actor/create"){
    
    /*
    *   send as post with required parameters:
    *   first_name
    *   last_name
    */
    $request->post('ActorController@create');

}else if($request->request_uri == "/actor/put"){

    /*
    *   send as post with required parameters:
    *   actor_id 
    *   first_name 
    *   last_name
    */
    $request->put('ActorController@update');

}else if($request->request_uri == "/actor/patch"){

    /*
    *   send as post with required parameters:
    *   actor_id
    *   first_name OR last_name
    */
    $request->patch('ActorController@update');

}else if($request->request_uri == "/actor/delete"){

    /*
    *   send as post with required parameter:
    *   actor_id
    */
    $request->delete('ActorController@delete');
}


