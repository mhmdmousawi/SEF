<?php

require_once __DIR__.'/../App/Actor.php';

class ActorController 
{
    private $actor;

    public function read()
    {
        $actor = new Actor;
        echo json_encode(
            
            $actor ->select("CONCAT(first_name, ' ' ,last_name) as 'Actor Name'")
            //just showing what the developer can use in this framework
                    //->select("*")
                    // ->where('first_name'," = ",'JULIA')
                    //->where('actor_id'," < ",'50')
                    //->whereIn('actor_id',[1,2,3,4,5])
                    ->limit(20)
                    ->orderBy("actor_id","DESC")
                    ->get()
        );
    }

    public function filter_names($variables = [])
    {
        $actor = new Actor;
        $actor->select("CONCAT(first_name, ' ' ,last_name) as 'Actor Name'");

        $var_count = count($variables);
        
        if($var_count > 2 || $var_count <= 0){
            echo json_encode(array("message" => "fail"));
            return;
        }
        
        $first_name = $variables[0];
        $actor->where("first_name","=", $first_name);

        if($var_count == 2){
            $last_name = $variables[1];
            $actor->where("last_name","=", $last_name);
        }

        echo json_encode($actor->get());
        return;
        
    }

    public function create($data)
    {
        $actor = new Actor;
        
        if(!$data['first_name'] || !$data['last_name']){
            echo json_encode($actor->errorMsg());
            return;
        }else {
            //handle spaces ** replace "+" with " " 
            $actor->first_name = $data['first_name'];
            $actor->last_name = $data['last_name'];
            echo json_encode($actor->save());
            return;
        }
    }

    public function update($data)
    {
        $actor = new Actor;

        if($data['actor_id'] && is_numeric($data['actor_id'])){
            $actor->where("actor_id","=",$data['actor_id']);
            if(!$data['first_name'] && !$data['last_name']){
                echo json_encode($actor->errorMsg());
                return;
            }else{
                if($data['first_name']){
                    $actor->set("first_name",$data['first_name']);
                }
                if($data['last_name']){
                    $actor->set("last_name",$data['last_name']);
                }
            }
            echo json_encode($actor->update());
            return;
        }else{
            echo json_encode($actor->errorMsg());
            return;
        }
    }

    public function delete($data)
    {   
        $actor = new Actor;

        if($data['actor_id'] && is_numeric($data['actor_id'])){
            $actor->where("actor_id","=",$data['actor_id']);
            echo json_encode($actor->delete());
        }else{
            echo json_encode($actor->errorMsg());
            return;
        }
    }

    public function error()
    {
        echo json_encode(array("message" => "fail"));
    }
}

?>