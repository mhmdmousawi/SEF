<?php

namespace Models\Film;

class Film{
 
    // database connection and table name
    private $conn;
    private $table_name = "film";
 
    // Film properties
    public $film_id;
    public $title;
    public $description;
    public $release_year;
    public $language_id;
    public $original_language_id;
    public $rental_duration;
    public $rental_rate;
    public $length;
    public $replacement_cost;
    public $rating;
    public $special_features;
    public $last_update;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}