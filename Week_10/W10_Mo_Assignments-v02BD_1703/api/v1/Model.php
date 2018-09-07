<?php

require_once 'config/database.php';

abstract class Model {

    // database connection and table name
    private $conn;
    protected $table_name;
    private $query ;
    public $fillables = " ";
    public $values = [];

    //filters
    private $select_filter = " * ";
    private $limit_filter = " ";
    private $order_by_filter = " ";
    private $where_filter = " ";
    private $set_filter = " ";

    public function __construct()
    {
        $this->setConn();
        $this->setTableName();
    }

    private function setConn()
    {
        $database = new Database;
        $db = $database->getConnection();
        $this->conn = $db;
    }

    public function setTableName(){
        $this->table_name = lcfirst(get_called_class());
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

    public function where($attribute,$operator = " = ", $value)
    {
        if($this->where_filter == " "){
            $this->where_filter = " WHERE " . $attribute . " " . $operator . " '" . $value ."' ";
        }else{
            $this->where_filter .= " AND " . $attribute . " " . $operator . " '" . $value ."' ";
        }
        return $this;
    }

    public function whereIn($attribute, $array)
    {
        if($this->where_filter == " "){
            $this->where_filter = " WHERE " . $attribute . " IN(" . implode(",", $array).") ";
        }else{
            $this->where_filter .= " AND " . $attribute . " IN(" . implode(",", $array).") ";
        }
        return $this;
    }

    public function set($attribute,$value)
    {
        
        if($this->set_filter == " "){
            $this->set_filter = " SET " . $attribute . " = '" . $value ."' ";
        }else{
            $this->set_filter .= " , " . $attribute . " = '" . $value ."' ";
        }
        return $this;
    }

    public function get()
    {
        $this->setQuerySelect();
        return $this->result();
    }

    public function setValues(){}

    public function save()
    {
        if($this->fillables==" "){
            return $this->errorMsg();
        }

        $attributes = $this->fillables;
        $this->setValues();
        //add "'" to each value
        $values_string = "";
        $values_num = count($this->values);
        $i = 0;

        foreach ($this->values as $value) {
            $i++;
            if( $i ==  $values_num ){
                $values_string .= "'".$value."'";
            }else{
                $values_string .= "'".$value."',";
            }
        } //values_string as string ex. "'mhmd','mousawi'"

        $this->query = " INSERT INTO " . $this->table_name ." ".
                        " ( " .$attributes . " ) ".
                        " VALUES ".
                        " ( " .$values_string . " ) ";

        $stmt = $this->conn->prepare($this->query);

        // execute query
        if(!$stmt->execute()){
            return $this->errorMsg();
        }

        // $last_id = $this->conn->lastInsertId();

        return $this->successMsg();     
    }

    public function update()
    {
        $this->setQueryUpdate();
        return $this->msgResult();
    }

    public function delete()
    {
        $this->setQueryDelete();
        return $this->msgResult();
    }

    private function setQueryDelete()
    {
        $this->query = " DELETE FROM " . $this->table_name . " ".
                        $this->where_filter . " ";
    }

    private function setQueryUpdate()
    {
        $this->query = " UPDATE " . $this->table_name . " ".
                        $this->set_filter . " " .
                        $this->where_filter . " ";
    }


    private function setQuerySelect()
    {
        $this->query = " SELECT ".$this->select_filter ." ".
                        " FROM " . $this->table_name . " ".
                        $this->where_filter . " ". 
                        $this->order_by_filter . " ". 
                        $this->limit_filter. " ";
    }

    private function msgResult()
    {
        $stmt = $this->conn->prepare($this->query);
        if($stmt->execute()){
            return $this->successMsg();
        }else{
            return $this->errorMsg();
        }
    }

    private function result()
    {
        $stmt = $this->conn->prepare($this->query);
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
            return $this->errorMsg();
        }
    }

    public function successMsg()
    {
        return array("message" => "success");
    }

    public function errorMsg()
    {
        return array("message" => "fail");
    }

}