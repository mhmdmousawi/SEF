<?php 
/*
* 	The main class
* 	Notes: 
*			still get and delete needed +++ validate adding on existing id
* 			1.Display manual to user
*/
require_once "Database.php";
require_once "Table.php";
require_once "DML.php";

class Controler
{

	private $currentDB = "Not Specified";
	private $currentTBL = "Not Specified";
	private $DML_transaction;

	function __construct()
	{
		$this->setDB("FS_Database");
		$this->setTBL("TABLENAME");

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
			if($query == "man"){
				echo "MANUAL".PHP_EOL;
				echo ">> ";
				continue;
			}
			
			//check the structure of each query 
			if(preg_match("/^CREATE\s*,\s*DATABASE\s*,\s*\"([^\"]+)\"$/", $query,$db_name)){

				$DDL_action = new Database("CREATE",$db_name[1]);
				$this->setDB($db_name[1]);

			}else if (preg_match("/^DELETE\s*,\s*DATABASE\s*,\s*\"([^\"]+)\"$/", $query,$db_name)){

				$DDL_action = new Database("DELETE",$db_name[1]);
				$this->setDB("Not Specified");

			}else if (preg_match("/^CREATE\s*,\s*TABLE\s*,\s*\"([^\"]+)\"\s*,COLUMNS(,\s*\"(\w*\s*)*\")+$/", $query,$config)){
				
				if($this->getDB() == "Not Specified"){
					echo "Please Specify the Database in which you want to add the table to".PHP_EOL;
					echo ">> ";
					continue;
				}
				$columns = "";
				$queryItems = explode(",", $query);
				for($i =4;$i<sizeof($queryItems);$i++){
					if($i == sizeof($queryItems) -1){
						$columns.= substr($queryItems[$i], 1, -1);
					}else{
						$columns.= substr($queryItems[$i], 1, -1).",";
					}
				}
				$this->setTBL($config[1]);
				$DDL_action = new Table("CREATE",$this->getDB(),$this->getTBL(),$columns);

			}else if (preg_match("/^ADD(,\"([^\"]+)\"\s*)+$/", $query)){

				if(!$this->openTransaction()){
					continue;
				}

				$columns = "";
				$queryItems = explode(",", $query);
				if((sizeof($queryItems)-1) != $this->getAttributesNumber()){
					echo "Please Specify the right number of attributes..".PHP_EOL;
					echo ">> ";
					continue;
				}
				for($i =1;$i<sizeof($queryItems);$i++){
					if($i == sizeof($queryItems) -1){
						$columns.= substr($queryItems[$i], 1, -1);
					}else{
						$columns.= substr($queryItems[$i], 1, -1).",";
					}
				}
				$this->get_DML_transaction()->doAction("ADD",$columns);
				//print_r($this->get_DML_transaction()->getTBL_Array());

			}else if (preg_match("/^GET\s*(,\s*\"(\w*\s*)*\"\s*){0,2}$/", $query)){
				
				if(!$this->openTransaction()){
					continue;
				}

				if(preg_match("/^GET\s*,\s*\"([^\"]+)\"\s*$/", $query,$config)){
					//echo "get records of specific id";
					if(is_numeric($config[1])){
						//search for id
						if(!$id = $this->getTableId()){
							continue;
						}
						$this->get_DML_transaction()->doAction("GET",$id,$config[1]);
					}else{
						//get all of that column
						$this->get_DML_transaction()->doAction("GET",$config[1],"");
					}
				}else if(preg_match("/^GET\s*$/", $query)){
					//echo "gets all records";
					$this->get_DML_transaction()->doAction("GET","","");
					
				}else if(preg_match("/^GET\s*,\s*\"([^\"]+)\"\s*,\s*\"([^\"]+)\"\s*$/", $query,$config)){
					//echo "get the record of a specific column and row";
					$this->get_DML_transaction()->doAction("GET",$config[1],$config[2]);
				}

			}else if (preg_match("/^DELETE\s*,\s*ROW,\"([^\"]+)\"$/", $query,$config)){
				if(!$this->openTransaction()){
					continue;
				}
				$this->get_DML_transaction()->doAction("DELETE",$config[1]);

			}else if(preg_match("/^COMMIT$/", $query)){
				
				if(!$this->openTransaction()){
					continue;
				}
				$this->get_DML_transaction()->commitToTable();

			}else if(preg_match("/^ROLLBACK$/", $query)){
				
				if(!$this->openTransaction()){
					continue;
				}
				$this->get_DML_transaction()->rollBackToTable();

			}else if(preg_match("/^SPECIFY\s*,\s*DATABASE\s*,\s*\"([^\"]+)\"\s*$/", $query,$config)){
				
				$this->setDB($config[1]);
				if($this->get_DML_transaction() != NULL){
					$this->get_DML_transaction()->commitToTable();
					$this->start_DML_transaction(NULL);
				}
				$this->setTBL("Not Specified");
				echo "The choosen database is specified successfully..".PHP_EOL;

			}else if(preg_match("/^SPECIFY\s*,\s*TABLE\s*,\s*\"([^\"]+)\"\s*$/", $query,$config)){
				
				if($this->getDB() == "Not Specified"){
					echo "Please Specify a Database first .. ".PHP_EOL;
					echo ">> ";
					continue;
				}
				$this->setTBL($config[1]);
				if($this->get_DML_transaction() != NULL){
					$this->get_DML_transaction()->commitToTable();
					$this->start_DML_transaction(NULL);
				}
				echo "The choosen table is specified successfully..".PHP_EOL;

			}else{
				
				echo "OPPS.. TYPO BRO.. (To read the manual please type \"man\")".PHP_EOL;

			}
			echo ">> ";
		}

	}

	function getAttributesNumber()
	{
		$db_name = $this->getDB();
		$tbl_name = $this->getTBL();

		$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;

		if(file_exists($tbl_path)){
			$fileOpened = fopen($tbl_path, "r");
			if($fileOpened){
				if($firstLine = fgets($fileOpened)){
					$attributes = explode(",", $firstLine);
					return sizeof($attributes);
				}
			}
		}else {
			echo "ERROR!! Somthing went wrong on the table ..".PHP_EOL;
			echo ">> ";
		}
		return false;
	}
	
	function getTableId()
	{
		$db_name = $this->getDB();
		$tbl_name = $this->getTBL();

		$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;

		if(file_exists($tbl_path)){
			$fileOpened = fopen($tbl_path, "r");
			if($fileOpened){
				if($firstLine = fgets($fileOpened)){
					$attributes = explode(",", $firstLine);
					return $attributes[0];
				}
			}
		}else {
			echo "ERROR!! Somthing went wrong on the table ..".PHP_EOL;
			echo ">> ";
		}
		return false;
	}

	function setDB($newDB_name)
	{
		$this->currentDB = $newDB_name;
	}

	function setTBL($newTBL_name)
	{
		$this->currentTBL = $newTBL_name;
	}

	function getDB()
	{
		return $this->currentDB;
	}

	function getTBL()
	{
		return $this->currentTBL;
	}

	function openTransaction()
	{
		if($this->getDB() == "Not Specified" || $this->getTBL() == "Not Specified"){
			echo "ERROR!! Database or Table in which you want to add the record is not specified..".PHP_EOL;
			echo ">> ";
			return false;
		}
		if($this->get_DML_transaction() == NULL){
			$DML_transaction = new DML($this->getDB(),$this->getTBL());
			$this->start_DML_transaction($DML_transaction);
		}
		return true;
	}

	function start_DML_transaction($dml_transaction)
	{
		$this->DML_transaction = $dml_transaction;
	}

	function get_DML_transaction()
	{
		return $this->DML_transaction;
	}
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
