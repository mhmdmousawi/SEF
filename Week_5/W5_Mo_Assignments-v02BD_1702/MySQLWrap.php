
<?php

require_once 'Config.php';

class MySQLWrap {

	private $connection;
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	
	function __construct()
	{
		//get all credintials 
		$connection = new Config();
		$this->setDBHost($connection->getDBHost()); 
		$this->setDBUser($connection->getDBUser());
		$this->setDBPassword($connection->getDBPasword());
		$this->setDBName($connection->getDBName());

	}

	function connect()
	{
		$connect_db = new mysqli(
						$this->getDBHost(),
						$this->getDBUser(),
						$this->getDBPasword(),
						$this->getDBName() 
					);

		if ( mysqli_connect_errno() ) {
			return false;
		}

		$this->setConnection($connect_db);
		return true;
	}

	function makeRentalOrder($inventory_id, $customer_id, $staff_id)
	{
		$query = "INSERT INTO rental(rental_date, inventory_id, customer_id, staff_id) ".
    			"VALUES(NOW(), ".$inventory_id.", ".$customer_id.", ".$staff_id.");";

    	if(!$this->connect()){
			return false;
		}
		$result = $this->getConnection()->query($query);

		//error in query
		if(!$result){
			return false;
		}
		return true;
	}

	public function getMoviesNames()
	{
		$names = array();
		$query = "select distinct F.film_id,F.title ".
				"from inventory as I ".
				"inner join film as F on F.film_id = I.film_id ".
				"where inventory_in_stock(I.inventory_id) ".
				"limit 20; ";

		if(!$this->connect()){
			return false;
		}
		$result = $this->getConnection()->query($query);

		//error in query
		if(!$result){
			return false;
		}

		while ($row = $result->fetch_assoc()) {
			$names[$row['film_id']] = $row['title'];
		}
		return $names;
	}

	function setDBHost($host)
	{
		$this->db_host = $host;
	}
	function setDBUser($user)
	{
		$this->db_user = $user;
	}
	function setDBPassword($pass)
	{
		$this->db_pass = $pass;
	}
	function setDBName($name)
	{
		$this->db_name = $name;
	}

	function getDBHost(){
		return $this->db_host;
	}
	function getDBUser()
	{
		return $this->db_user;
	}
	function getDBPasword()
	{
		return $this->db_pass;
	}
	function getDBName()
	{
		return $this->db_name;
	}
	function setConnection($connection)
	{
		$this->connection = $connection;
	}

	function getConnection()
	{
		return $this->connection;
	}
}
?>