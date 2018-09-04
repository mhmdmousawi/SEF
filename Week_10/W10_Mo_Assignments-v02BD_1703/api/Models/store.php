<?php

namespace Models\Store;

class Store{
 
    // database connection and table name
    private $conn;
    private $table_name = "store";
 
    // Actor properties
    public $store_id;
    public $manager_staff_id;
    public $address_id;
    public $last_update;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}