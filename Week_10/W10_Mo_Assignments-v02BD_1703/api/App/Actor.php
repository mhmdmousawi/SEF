<?php

// namespace Models\Actor;
// require_once '../config/database.php';
// include_once '../Mousawi/framework/Model.php';
require_once '../Model.php';

// require_once '../testParent.php';


class Actor extends Model{

    public function setTableName($table_name){
        $this->table_name = $table_name;
    }
    
}