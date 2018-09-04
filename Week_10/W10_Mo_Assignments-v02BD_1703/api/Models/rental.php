<?php

namespace Models\Rental;

class Rental{
 
    // database connection and table name
    private $conn;
    private $table_name = "rental";
 
    // Actor properties
    public $rental_id;
    public $rental_date;
    public $inventory_id;
    public $customer_id;
    public $return_date;
    public $staff_id;
    public $last_update;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}