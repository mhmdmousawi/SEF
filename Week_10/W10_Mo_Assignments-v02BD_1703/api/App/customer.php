<?php

namespace Models\Customer;

class Customer{
 
    // database connection and table name
    private $conn;
    private $table_name = "customer";
 
    // Customer properties
    public $customer_id;
    public $store_id;
    public $first_name;
    public $last_name;
    public $email;
    public $address_id;
    public $active;
    public $create_date;
    public $last_update;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}