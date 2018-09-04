<?php

namespace Models\Staff;

class Staff{
 
    // database connection and table name
    private $conn;
    private $table_name = "staff";
 
    // Actor properties
    public $staff_id;
    public $first_name;
    public $last_name;
    public $address_id;
    public $picture;
    public $email;
    public $store_id;
    public $active;
    public $username;
    public $password;
    public $last_update;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}