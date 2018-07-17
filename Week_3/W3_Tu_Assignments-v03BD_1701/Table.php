<?php 
/*
* Notes: add update table and all other functions
* need to: check on the DB and Table name at the beginning then act cool
*
*/
	class Table
	{
		private $DB_Name;
		private $TBL_Name;
		private $TBL_Columns;

		function __construct($query_type, $action, $DB_Name, $TBL_Name, $TBL_Columns="")
		{
			$this->setDB_Name($DB_Name);
			$this->setTBL_Name($TBL_Name);
			$this->setTBL_Columns($TBL_Columns);

			$DB_Path = "Databases".DIRECTORY_SEPARATOR.$this->getDB_Name();
			if(!file_exists($DB_Path)){
				echo "Please specify a created database".PHP_EOL;
				return;
			}

			if($query_type == "DLL"){
				if($action == "CREATE"){
					$this->createTBL(
						$this->getDB_Name(),
						$this->getTBL_Name(),
						$this->getTBL_Columns()
					);
				}else if($action == "UPDATE"){
					$this->updateTBL();
				}else if($action == "DROP"){
					$this->dropTBL(
						$this->getDB_Name(),
						$this->getTBL_Name()
					);
				}else{
					echo "OPPS.. TYPO...";
				}
			}else if($query_type == "DML"){
				if($action == "ADD"){
					$this->addToTBL(
						$this->getDB_Name(),
						$this->getTBL_Name(),
						$this->getTBL_Columns()
					);
				}else if($action == "GET"){
					$this->getFromTable(
						$this->getDB_Name(),
						$this->getTBL_Name(),
						$this->getTBL_Columns()
					);
				}else if($action == "DELETE"){
					$this->deleteFromTable(
						$this->getDB_Name(),
						$this->getTBL_Name(),
						$this->getTBL_Columns()
					);
				}else{
					echo "OPPS.. TYPO...";
				}
			}else {
				echo "ERROR! No such query type...";
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
			if(file_exists($tbl_path)){
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

		function addToTBL($db_name, $tbl_name, $tbl_columns)
		{
			$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;

			if(file_exists($tbl_path)){
				$fileOpened = fopen($tbl_path, "a");

				if($fileOpened){

					//validate structure
					//get attribute number added
					$attrib_added = explode(",", $tbl_columns);
					$attribNumber_added = sizeof($attrib_added);

					//validate that first is an id and if it exists
					$id_added = $attrib_added[0];
					if(!is_numeric($id_added)){
						echo "Please specify an Id to your record..".PHP_EOL;
						return;
					}else if($this->idExists($db_name, $tbl_name, $id_added)){
						echo "Error!! Please specify another Id, ".
							"the given Id is already reserved..".PHP_EOL;
						return;
					}


					//get attribute number of the tbl
					$attribNumber_tbl = $this->getAttribNumber($db_name, $tbl_name);

					if($attribNumber_added > $attribNumber_tbl){
						echo "Error!! Adding more attributes than expected.. ".PHP_EOL;
						return;
					}
					if($attribNumber_added < $attribNumber_tbl){
						//add some "," to complete the targeted attributes number
						$numberDiffrence = $attribNumber_tbl - $attribNumber_added;
						for( $i = 0; $i < $numberDiffrence; $i++ ){
							$tbl_columns .= ",";
						}
					}

					file_put_contents($tbl_path, $tbl_columns.PHP_EOL, FILE_APPEND | LOCK_EX);
					fclose($fileOpened);

					echo "A record has been added succesfully to table \"".$tbl_name.
					"\" in database \"".$db_name."\"".PHP_EOL;

				}else{
					echo "Error adding record to table..".PHP_EOL;
				}

			}else{
				echo "Error!! Table \"".$tbl_name."\" does not exist in database \"".$db_name."\"".PHP_EOL;
			}
		}


		function deleteFromTable($db_name, $tbl_name, $tbl_columns)
		{
			$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;

			if(file_exists($tbl_path)){
				$fileOpened = fopen($tbl_path, "w+");

				if($fileOpened){

					//validate that it is an id 
					$id_target = $tbl_columns;
					if(!is_numeric($id_target)){
						echo "Please specify an Id for the record that you want to delete..".PHP_EOL;
						return;
					}

					$found = false;
					while(!feof($fileOpened)){
						$record = fgets($fileOpened);
						$attributes = explode(",", $record);
						$recordId = $attributes[0];
						if($recordId == $id_target){
							$found = true;
							//on this line do the delete

							str_replace($record, "", $record);

							echo "The record has been deleted succesfully from table \"".$tbl_name.
								"\" in database \"".$db_name."\"".PHP_EOL;
						}
					}
					if( $found == false ){
						echo "Error!! Please specify another Id, ".
							"this table doesn't contain this Id..".PHP_EOL;
						return;
					}
				}else{
					echo "Error deleting record from table..".PHP_EOL;
				}

			}else{
				echo "Error!! Table \"".$tbl_name."\" does not exist in database \"".$db_name."\"".PHP_EOL;
			}
		}

		function getAttribNumber($db_name,$tbl_name)
		{
			$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;
			if(file_exists($tbl_path)){
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
			if(file_exists($tbl_path)){
				$fileOpened = fopen($tbl_path,"r");
				if($fileOpened){
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