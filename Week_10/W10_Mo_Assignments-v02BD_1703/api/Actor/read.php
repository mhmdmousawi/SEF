<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../App/Actor.php';

$actor = new Actor;
$actor->setTableName("actor");


echo json_encode(
    // $actor->read($record_needed)->get()
    
    $actor ->select("last_name")
            ->limit(10)
            ->orderBy("actor_id","DESC")
            ->get()
);

?>