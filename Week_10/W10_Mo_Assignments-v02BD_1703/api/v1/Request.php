<?php

//need to require all controllers
//all php files in controller dir
require __DIR__."/Controllers/ActorController.php";

class Request 
{
    public $routes = array();
    public $request_method;
    public $request_uri;
    public $request_url;

    public function __construct()
    {
        $this->setCurrentUri();

        //validate url
        $this->routes = explode('/', $this->request_uri);
        $this->setRequestMethod();
    }

    public function setCurrentUri()
    {
        $basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        $uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
        if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
        $uri = '/' . trim($uri, '/');
        // return $uri;
        $this->request_url = $_SERVER['REQUEST_URI'];
        
        $this->request_uri = $uri;
    }

    public function setRequestMethod()
    {
        $this->request_method = $_SERVER['REQUEST_METHOD'];
    }

    public function get($rout, $controller_method)
    {
        if($this->request_method != 'GET'){
            return;
        }

        $controller_method_arr = explode("@",$controller_method);
        $conroller = $controller_method_arr[0];
        $method = $controller_method_arr[1];

        $model_controller = new $conroller;
        $model_controller->$method();
    }
    
    function get_with_var($all_rout,$main_rout,$controller_method){
    
        if($this->request_method != 'GET'){
            return;
        }
    
        $controller_method_arr = explode("@",$controller_method);
        $conroller = $controller_method_arr[0];
        $method = $controller_method_arr[1];
    
        $variables_rout = str_replace($main_rout,"",$all_rout);
        $variables = explode('/', $variables_rout);
    
        $model_controller = new $conroller;
        $model_controller->$method($variables);
    }

    private function get_data()
    {
        $fp = fopen($this->request_url);
        $entityBody = file_get_contents('php://input');
        $keys_values = explode("&",$entityBody);
        $data = [];
        
        foreach($keys_values as $key_value){
            $key_value_arr = explode("=",$key_value);
            $key=$key_value_arr[0];
            $value=$key_value_arr[1];
            $data[$key] = $value; 
        }
        return $data;
    }
    public function mother_request($controller_method){

        $data = $this->get_data();

        $controller_method_arr = explode("@",$controller_method);
        $conroller = $controller_method_arr[0];
        $method = $controller_method_arr[1];


        $model_controller = new $conroller;
        $model_controller->$method($data);
    } 

    public function post($controller_method)
    {
        if($this->request_method != 'POST'){
            return;
        }
        
        $this->mother_request($controller_method);
    }

    public function put($controller_method)
    {
        if($this->request_method != 'PUT'){
            return;
        }
        
        $this->mother_request($controller_method);
    }

    public function patch($controller_method)
    {
        if($this->request_method != 'PATCH'){
            return;
        }
        
        $this->mother_request($controller_method);
    }

    public function delete($controller_method)
    {
        if($this->request_method != 'DELETE'){
            return;
        }
        
        $this->mother_request($controller_method);
    }
}