<?php 

class Table
{
	private $DB_Name;
	private $TBL_Name;
	private $TBL_Columns;

	function __construct($action, $DB_Name, $TBL_Name, $TBL_Columns="")
	{
		$this->setDB_Name($DB_Name);
		$this->setTBL_Name($TBL_Name);
		$this->setTBL_Columns($TBL_Columns);

		$DB_Path = "Databases".DIRECTORY_SEPARATOR.$this->getDB_Name();
		if ( !file_exists($DB_Path) ) {
			echo "Please specify a created database".PHP_EOL;
			return;
		}
	
		if ( $action == "CREATE" ) {
			$this->createTBL(
				$this->getDB_Name(),
				$this->getTBL_Name(),
				$this->getTBL_Columns()
			);
		} else if ( $action == "UPDATE" ) {
			$this->updateTBL();
		} else if ( $action == "DROP" ) {
			$this->dropTBL(
				$this->getDB_Name(),
				$this->getTBL_Name()
			);
		} else {
			echo "OPPS.. TYPO...";
		}
	}

	function createTBL($db_name, $tbl_name, $tbl_columns)
	{
		$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;

		if(!file_exists($tbl_path)){
			$fileOpened = fopen($tbl_path, "w");
			if($fileOpened){
				echo "Table \"".$tbl_name.
				"\" is has been created succesfully in database \"".$db_name.
				"\"".PHP_EOL;

				fwrite($fileOpened, $tbl_columns.PHP_EOL);
				fclose($fileOpened);
			}else{
				echo "Error creating table..";
			}
		}else{
			echo "Table \"".$tbl_name."\" is already created in database \"".$db_name."\"".PHP_EOL;
		}
	}

	function dropTBL($db_name, $tbl_name)
	{
		$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;
		if ( file_exists($tbl_path) ) {
			$fileOpened = fopen($tbl_path, "r");
			if($fileOpened){
				unlink($tbl_path);

				echo "Table \"".$tbl_name.
				"\" is has been deleted succesfully in database \"".$db_name.
				"\"".PHP_EOL;
			}else{
				echo "Error creating table..";
			}
		}else{
			echo "Table \"".$tbl_name."\" does not exist in database \"".$db_name."\"".PHP_EOL;
		}
	}

	function getAttribNumber($db_name,$tbl_name)
	{
		$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;
		if ( file_exists($tbl_path)){
			$fileOpened = fopen($tbl_path,"r");
			if($fileOpened){
				$attribNumber_tbl = sizeof(explode(",", fgets($fileOpened)));
				return $attribNumber_tbl;
			}else{
				echo "Error accessing the table".PHP_EOL;
			}
		}else{
			echo "Error!! table \"".$tbl_name."\" does not exists in database \"".$db_name."\"".PHP_EOL;
			return 0;
		}
	}

	function idExists($db_name, $tbl_name, $id)
	{
		$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;
		if ( file_exists($tbl_path)){
			$fileOpened = fopen($tbl_path,"r");
			if ( $fileOpened){
				//search in file for the id
				$found = false;
				while(!feof($fileOpened)){
					$record = fgets($fileOpened);
					$attributes = explode(",", $record);
					$recordId = $attributes[0];
					if($recordId == $id){
						$found = true;
					}
				}
				return $found;
			}else{
				echo "Error accessing the table".PHP_EOL;
			}
		}else{
			echo "Error!! table \"".$tbl_name."\" does not exists in database \"".$db_name."\"".PHP_EOL;
			return 0;
		}
	}

	function setDB_Name($db_name)
	{
		$this->DB_Name = $db_name;
	}

	function getDB_Name()
	{
		return $this->DB_Name;
	}

	function setTBL_Name($tbl_name)
	{
		$this->TBL_Name = $tbl_name; 
	}

	function getTBL_Name()
	{
		return $this->TBL_Name;
	}

	function setTBL_Columns($tbl_columns)
	{
		$this->TBL_Columns = $tbl_columns; 
	}

	function getTBL_Columns()
	{
		return $this->TBL_Columns;
	}
}
?>