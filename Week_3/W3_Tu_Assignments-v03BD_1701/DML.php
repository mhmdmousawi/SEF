<?php 
/*
* A class to get, add, delete records from a table 
* Notes: get is done ..........still need to make add and delete and commit changes 
*
*/
	class DML
	{
		private $DB_Name;
		private $TBL_Name;
		private $TBL_Column;
		private $TBL_Row;
		private $TBL_Array = array();


		function __construct($action, $DB_Name, $TBL_Name, $TBL_Column="",$TBL_Row="")
		{
			$this->setDB_Name($DB_Name);
			$this->setTBL_Name($TBL_Name);
			$this->setTBL_Array($this->getDB_Name(), $this->getTBL_Name());
			$this->setTBL_Column($TBL_Column);
			$this->setTBL_Row($TBL_Row);
			//print_r($this->getTBL_Array());
			


			//actions may be:
			//GET
			//ADD
			//DELETE

			if($action == "GET"){
				$this->getFromTable(
					$this->getTBL_Array(),
					$this->getTBL_Column(),
					$this->getTBL_Row()
				);
			}else if($action == "ADD"){

			}else if($action == "DELETE"){

			}else{
				echo "OPPS.. TYPO..".PHP_EOL;
			}
		}

		function getFromTable($tbl_array, $tbl_column,$tbl_row)
		{
			//search inside a 2D array for either column or row

			if($tbl_row == "" && $tbl_column == ""){

				echo "--------------------".PHP_EOL;
				foreach ($tbl_array["id"] as $key => $value) {
					if($key == 0)
						continue;
					foreach ($tbl_array as $attrib => $value) {
						
						echo $attrib.": ". $tbl_array[$attrib][$key].PHP_EOL;
					}
					echo "--------------------".PHP_EOL;
				}

			}else if($tbl_row == ""){
				//we need to display all records of that column
				echo $tbl_column."'s ".PHP_EOL;
				echo "---------------".PHP_EOL;
				foreach ($tbl_array[$tbl_column] as $key => $value) {
					if($key == 0)
						continue;
					echo  $tbl_array[$tbl_column][$key].PHP_EOL;
				}
			}else{
				//get that specific attribute of that record
				$indexToGet = -1;

				foreach ($tbl_array[$tbl_column] as $key => $value) {
					if($value == $tbl_row){
						$indexToGet = $key;
					}
				}

				if($indexToGet < 0){
					echo "No such Id in this table, try another Id ... ".PHP_EOL;
					return;
				}

				foreach ($tbl_array as $attrib => $value) {
					echo $attrib.": ". $tbl_array[$attrib][$indexToGet].PHP_EOL;
				}
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

		function setTBL_Column($tbl_column)
		{
			$this->TBL_Column = $tbl_column; 
		}

		function getTBL_Column()
		{
			return $this->TBL_Column;
		}

		function setTBL_Row($tbl_row)
		{
			$this->TBL_Row = $tbl_row; 
		}

		function getTBL_Row()
		{
			return $this->TBL_Row;
		}

		function setTBL_Array($db_name,$tbl_name)
		{
			$tbl_array = array();
			$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;
			if(!file_exists($tbl_path)){
				echo "ERROR!! No such table in database \"".$db_name."\"".PHP_EOL;
				return;
			}
			//access file and convert to array
			$fileOpened = fopen($tbl_path,"r");
			if($fileOpened){
				if($record_first = fgets($fileOpened)){
					$attributes = explode(",", $record_first);
					foreach($attributes as $key => $attribute){
						$attribute = str_replace(PHP_EOL, "", $attribute);
						$tbl_array[$attribute][]= $attribute;
					}
					
				}
				while(!feof($fileOpened)){
					if($record = fgets($fileOpened)){
						$record_info = explode(",", $record);

						foreach($attributes as $key_attr => $attribute){
							$attribute = str_replace(PHP_EOL, "", $attribute);
							$record_info[$key_attr] = str_replace(PHP_EOL, "", $record_info[$key_attr]);
							$tbl_array[$attribute][]= $record_info[$key_attr];
						}
					}
				}
				//print_r($tbl_array);
				$this->TBL_Array =  $tbl_array;
			}else{
				echo "Error accessing the table".PHP_EOL;
			}
		}

		function getTBL_Array()
		{
			return $this->TBL_Array;
		}
	}