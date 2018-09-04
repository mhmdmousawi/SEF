<?php

namespace Models\Address;

class Address{
 
    // database connection and table name
    private $conn;
    private $table_name = "address";
 
    // Actor properties
    public $address_id;
    public $address;
    public $address2;
    public $district;
    public $city_id;
    public $postal_code;
    public $phone;
    public $location;
    public $last_update;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}