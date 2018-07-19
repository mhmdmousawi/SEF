<?php 

class DML
{
	private $DB_Name;
	private $TBL_Name;
	private $TBL_Column;
	private $TBL_Row;
	private $TBL_Array = array();

	function __construct($DB_Name, $TBL_Name)
	{
		$this->setDB_Name($DB_Name);
		$this->setTBL_Name($TBL_Name);
		$this->setTBL_Array($this->getDB_Name(), $this->getTBL_Name());
	}

	function commitToTable()
	{
		//overwrite the file of that table with all new added to array
		$array = $this->getTBL_Array();
		$db_name = $this->getDB_Name();
		$tbl_name = $this->getTBL_Name();
		$tbl_path = "Databases".DIRECTORY_SEPARATOR.$db_name.DIRECTORY_SEPARATOR.$tbl_name;

		$array_size = sizeof($array);
		$sub_array_size = 0 ;
		foreach ($array as $key => $value) {
			$sub_array_size = sizeof($array[$key]);
		}

		if ( file_exists($tbl_path) ) {
			$fileOpened = fopen($tbl_path, "w");
			for ( $j = 0; $j < $sub_array_size ; $j++ ) {
				$i=0;
				foreach ($array as $key => $value) {
					//fgets($fileOpened);
					if(++$i === $array_size){
						fwrite($fileOpened, $array[$key][$j]);
					}else{
						fwrite($fileOpened, $array[$key][$j].",");
					}
				}
				fwrite($fileOpened, PHP_EOL);	
			}
			echo "All the work is saved now!".PHP_EOL;
		} else {
			echo "ERROR!! Couldn't commit! Something went wrong with table file".PHP_EOL;
		}
	}

	function rollBackToTable()
	{
		$this->setTBL_Array($this->getDB_Name(), $this->getTBL_Name());
		echo "We took you back to the last saved point!".PHP_EOL;
	}

	function doAction($action,$TBL_Column="",$TBL_Row="")
	{
		$this->setTBL_Column($TBL_Column);
		$this->setTBL_Row($TBL_Row);

		if ( $action == "GET" ) {
			$this->getFromTable(
				$this->getTBL_Array(),
				$this->getTBL_Column(),
				$this->getTBL_Row()
			);
		} else if ( $action == "ADD" ) {
			$this->addToTable(
				$this->getTBL_Array(),
				$this->getTBL_Column()
			);
		} else if ( $action == "DELETE" ) {
			$this->deleteFromTable(
				$this->getTBL_Array(),
				$this->getTBL_Column()//in this case it's the id
			);
		} else {
			echo "OPPS.. TYPO..".PHP_EOL;
		}
	}

	function getFromTable($tbl_array, $tbl_column,$tbl_row)
	{
		$index=0;
		$numberOfRecords =0;

		foreach ( $tbl_array as $key => $value ) {
			if($index==0){
				$id_of_table = $key;
			}
			$index++;
		}

		if ( $tbl_row == "" && $tbl_column == "" ) {
			
			echo "--------------------".PHP_EOL;
			foreach ( $tbl_array[$id_of_table] as $key => $value ) {
				if($key == 0){
					continue;
				}
				foreach ( $tbl_array as $attrib => $value ) {
					if($tbl_array[$attrib][$key] == NULL){
						echo $attrib.": NULL".PHP_EOL;
					}else{
						echo $attrib.": ". $tbl_array[$attrib][$key].PHP_EOL;
					}
				}
				echo "--------------------".PHP_EOL;
				$numberOfRecords++;
			}
			if($numberOfRecords<1){
				echo "This table is empty.".PHP_EOL;
			}

		} else if( $tbl_row == "") {

			echo $tbl_column."'s ".PHP_EOL;
			echo "--------------------".PHP_EOL;
			foreach ($tbl_array[$tbl_column] as $key => $value) {
				if($key == 0 || $tbl_array[$tbl_column][$key] == ""){
					continue;
				}
				echo  $tbl_array[$tbl_column][$key].PHP_EOL;
				$numberOfRecords++;
			}
			if ( $numberOfRecords<1 ) {
				echo "This table is empty.".PHP_EOL;
			}
		} else {
			//get that specific attribute of that record
			$indexFound = false;

			foreach ( $tbl_array[$tbl_column] as $key => $value ) {
				if( $value == $tbl_row ) {
					$indexToGet = $key;
					$indexFound = true;
				}
			}

			if ( $indexFound == false ) {
				echo "No such record in this table, please try again... ".PHP_EOL;
				return;
			}

			foreach ( $tbl_array as $attrib => $value) {
				echo $attrib.": ". $tbl_array[$attrib][$indexToGet].PHP_EOL;
			}
		}
	}

	function addToTable($tbl_array, $tbl_columns)
	{
		//validate structure
		//get attribute number added
		$attrib_added = explode(",", $tbl_columns);
		$attribNumber_added = sizeof($attrib_added);

		//validate that first is an id and if it exists
		$id_added = $attrib_added[0];
		if ( !is_numeric($id_added) ) {
			echo "Please specify an Id to your record..".PHP_EOL;
			return;
		}
		if ( $this->idExists($tbl_array,$id_added) ) {
			echo "Please specify another Id, ".
				"the given Id is already reserved..".PHP_EOL;
			return;
		}
		$i = 0;
		foreach ($tbl_array as $key => $value) {
			$sub_array_size = sizeof($tbl_array[$key]);
			$tbl_array[$key][$sub_array_size] = $attrib_added[$i++];		
		}

		$this->TBL_Array = $tbl_array;
		echo "Record ADDED".PHP_EOL;
	}

	function idExists($tbl_array,$id)
	{
		$id_attr = $this->getTableId($tbl_array);
		
		foreach ( $tbl_array[$id_attr] as $key => $value ) {
			if( $tbl_array[$id_attr][$key] == $id ) {
				return true;
			}
		}
		return false;
	}

	function getTableId($tbl_array)
	{
		foreach ($tbl_array as $key => $value) {
				return $key;
		}
	}

	function deleteFromTable($tbl_array, $tbl_column)
	{
		$found = false;
		$index = 0 ;
		$index_to_be_deleted = -1;

		$id_target = $tbl_column;
		if ( !is_numeric($id_target) ) {
			echo "Please specify an Id for the record that you want to delete..".PHP_EOL;
			return;
		}

		foreach ( $tbl_array as $key => $value ) {
			if($index==0){
				$id_of_table = $key;
			}
			$index++;
		}

		foreach ( $tbl_array[$id_of_table] as $key => $value) {
			if ( $value == $id_target ) {
				$index_to_be_deleted = $key;
				$found = true;
			}
		}

		if ( $found == false ) {
			echo "This table doesnt have Id provided".PHP_EOL;
			return;
		}

		foreach ( $tbl_array as $key => $value ) {
			array_splice($tbl_array[$key],$index_to_be_deleted,1);
		}

		$this->TBL_Array = $tbl_array;
		echo "Record DELETED".PHP_EOL;
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