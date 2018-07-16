<?php 

	require_once "Database.php";
	require_once "Table.php";

	//if user attempted to create db
	//$newDB = new Database("CREATE","FS_Database");

	//if the user attempted to add a table to database
	$newTBL = new Table("CREATE","FS_Database","Employee","column1, columns2, column3");

	//if the user attempted to drop a table from database
	//$newTBL = new Table("DROP","FS_Database","Employee");
?>