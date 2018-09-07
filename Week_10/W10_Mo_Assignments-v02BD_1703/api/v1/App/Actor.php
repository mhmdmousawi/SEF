<?php

require_once __DIR__.'/../Model.php';

class Actor extends Model
{
    public $first_name;
    public $last_name;
    public $attributes;

    public $fillables = 'first_name, last_name';
    public $values = [];

    //values and fillables should match
    public function setValues()
    {
        $this->values = [
            $this->first_name,
            $this->last_name
        ];
    } 
}