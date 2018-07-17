<?php 

	require_once "Database.php";
	require_once "Table.php";

	//private $current_db;
	//private $current_tbl;



	//if user attempted to create db
	//$newDB_action = new Database("CREATE","FS_Database");

	//if the user attempted to add a table to database
	//$newTBL_action = new Table("CREATE","FS_Database","Employee","id, fname, lname, job");

	//if the user attempted to drop a table from database
	//$newTBL_action = new Table("DROP","FS_Database","Employee");

	//if the user attempted to add a record to table within a database
	$newTBL_action = new Table("ADD","FS_Database","Employee","10, Bassem, Dghaidi, SEF Instructor");

?>