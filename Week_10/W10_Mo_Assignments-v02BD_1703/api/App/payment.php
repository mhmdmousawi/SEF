<?php

namespace Models\Payment;

class Payment{
 
    // database connection and table name
    private $conn;
    private $table_name = "payment";
 
    // Payment properties
    public $payment_id;
    public $customer_id;
    public $staff_id;
    public $rental_id;
    public $amount;
    public $payment_date;
    public $last_update;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}