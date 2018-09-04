<?php

include_once 'config/database.php';

abstract class Model {

    // database connection and table name
    private $conn;
    protected $table_name;
    private $query ;

    //filters
    private $select_filter = " * ";
    private $limit_filter = " ";
    private $order_by_filter = " ";

    abstract function setTableName($table_name);

    public function __construct()
    {
        $this->setConn();
    }

    private function setConn()
    {
        $database = new Database;
        $db = $database->getConnection();
        $this->conn = $db;
    }

    // FILTER FUNCTIONS 
    public function select($attributes)
    {
        $this->select_filter = " ". $attributes. " ";
        return $this;
    }

    public function limit($limit_num)
    {
        $limit_condition = " ";
        if ($limit_num > 0 ){
            $limit_condition = " limit ". $limit_num. " ";
        }else{
            $limit_condition = " ";
        }

        $this->limit_filter = $limit_condition;
        return $this;
    }

    public function orderBy($attribute, $order = "ASC")
    {
        $this->order_by_filter = " ORDER BY " .$attribute . " ". $order . " ";
        return $this;
    }

    public function get()
    {
        $this->setQuery();
        return $this->result();
    }

    private function setQuery()
    {
        $this->query = " SELECT ".$this->select_filter ." ".
                        " FROM " . $this->table_name . " ".
                        $this->order_by_filter . " ". 
                        $this->limit_filter. " ";
    }
    private function result()
    {
        // prepare query statement
        $stmt = $this->conn->prepare($this->query);
        // execute query
        $stmt->execute();

        $num = $stmt->rowCount();
        if($num>0){
 
            // actors array
            $result_array=array();
            $result_array["records"]=array();
         
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                array_push($result_array["records"], $row);
            }
         
            $result_array["message"]= "success";
            return $result_array;
        }
         
        else{
            return array("message" => "fail");
        }
    }

    
}