<?php 

	require_once "Database.php";
	require_once "Table.php";
	require_once "DML.php";

	//private $current_db;
	//private $current_tbl;


	echo "Hello to MousawiDB: ".PHP_EOL;
	echo "Please write your queries below: (Type \"quit\" to exit)".PHP_EOL;
	echo ">> ";
	//input 
	while ($query = fgets(STDIN)) {
		$query = str_replace(PHP_EOL, "", $query);
		if($query === "quit"){
			echo "Thank You for using MousawiDB".PHP_EOL;
			break;
		}
		if($query === "man mousawiDB"){
			echo "MANUAL".PHP_EOL;
			echo ">> ";
			continue;
		}
		//check the structure of each query 

		if(preg_match("/^CREATE\s*,\s*DATABASE\s*,\s*\"(\w*\s*)*\"$/", $query)){
			echo "CREATE A DATABASE".PHP_EOL;
		}else if (preg_match("/^DELETE\s*,\s*DATABASE\s*,\s*\"(\w*\s*)*\"$/", $query)){
			echo "DELETE A DATABASE".PHP_EOL;
			
		}else if (preg_match("/^CREATE\s*,\s*TABLE\s*,\s*\"(\w*\s*)*\"\s*,COLUMNS(,\s*\"(\w*\s*)*\")+$/", $query)){
			echo "CREATE A TABLE with columns specified".PHP_EOL;
		}else if (preg_match("/^ADD\s*(,\s*\"(\w*\s*)*\"\s*)+$/", $query)){
			echo "ADD a record in a table".PHP_EOL;
		}else if (preg_match("/^GET\s*(,\s*\"(\w*\s*)*\"\s*){0,2}$/", $query)){

			if(preg_match("/^GET\s*,\s*\"[a-zA-Z0-9]*\s*\"\s*$/", $query)){
				echo "get records of specific id";
			}else if(preg_match("/^GET\s*$/", $query)){
				echo "gets all records";
			}else {
				echo "get the record of a specific column and row";
			}
		}else if (preg_match("/^DELETE\s*,\s*ROW,\"\d*\"$/", $query)){
			echo "DELETE a record in this table".PHP_EOL;
		}else{
			echo "OPPS.. TYPO BRO.. (To read the manual please type \"man mousawiDB\")".PHP_EOL;

		}
		echo ">> ";
	}
	//if user attempted to create db
	//$DDL_action = new Database("CREATE","TEST_Database");

	//if user attempted to delete db
	//$DDL_action = new Database("DELETE","TEST_Database");

	//if the user attempted to add a table to database
	//$DDL_action = new Table("CREATE","FS_Database","TEST","id,fname,lname,job");

	//if the user attempted to drop a table from database
	//$DDL_action = new Table("DROP","FS_Database","TEST");

	//DML
	//$DML_transaction = new DML("FS_Database","TEST");
	//get all records
	//$DML_transaction->doAction("GET","","");//validate the id not to be 0 
	
	//get all records of a specific column
	//$DML_transaction->doAction("GET","lname","");//validate the id not to be 0 
	
	//get specific id
	//$DML_transaction->doAction("GET","id","1");//validate the id not to be 0 
	
	//$DML_transaction->commitToTable();
	

	//add a record
	//validate if more or less attributes and id if exists
	//$DML_transaction->doAction("ADD","1,Test,test,testinging");
	//$DML_transaction->commitToTable();

	//deleter a record by id
	//$DML_transaction->doAction("DELETE","1");
	//$DML_transaction->commitToTable();



	
?>