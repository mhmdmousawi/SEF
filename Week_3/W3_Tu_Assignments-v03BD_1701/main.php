<?php 

	require_once "Database.php";
	require_once "Table.php";
	require_once "DML.php";

	//private $current_db;
	//private $current_tbl;



	//if user attempted to create db
	//$newDB_action = new Database("CREATE","FS_Database");

	//if the user attempted to add a table to database
	//$newTBL_action = new Table("CREATE","FS_Database","Employee","id, fname, lname, job");

	//if the user attempted to drop a table from database
	//$newTBL_action = new Table("DROP","FS_Database","Employee");

	//if the user attempted to add a record to table within a database
	//$newTBL_action = new Table("ADD","FS_Database","Employee","10, Bassem, Dghaidi, SEF Instructor");

	//DML
	//get all records
	//$DML_transaction = new DML("GET","FS_Database","Employee","","");//validate the id not to be 0 
	
	//get all records of a specific column
	$DML_transaction = new DML("GET","FS_Database","Employee","lname","");//validate the id not to be 0 
	
	//get specific id
	//$DML_transaction = new DML("GET","FS_Database","Employee","id","1");//validate the id not to be 0 
	
	//echo $new_record;
?>