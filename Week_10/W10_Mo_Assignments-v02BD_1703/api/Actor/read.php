<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../App/Actor.php';

$actor = new Actor;

echo json_encode(
    
    //$actor ->select("CONCAT(first_name, ' ' ,last_name) as 'Actor Name'")
     $actor ->select("*")
            // ->where('first_name'," = ",'JULIA')
            //->where('actor_id'," < ",'50')
            //->whereIn('actor_id',[1,2,3,4,5])
            ->limit(10)
            // ->orderBy("actor_id","DESC")
            ->get()
);

?>