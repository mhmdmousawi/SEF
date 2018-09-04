<?php

namespace Models\Actor;

class Actor{
 
    // database connection and table name
    private $conn;
    private $table_name = "actor";
 
    // Actor properties
    public $actor_id;
    public $first_name;
    public $last_name;
    public $last_update;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}