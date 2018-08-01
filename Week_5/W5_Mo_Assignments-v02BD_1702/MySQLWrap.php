
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

	function login($email)
	{
		$query = "SELECT customer_id,first_name from customer where email = '".$email."' ";

		if(!$this->connect()){
			return false;
		}
		$result = $this->getConnection()->query($query);

		//error in query
		if(!$result){
			return false;
		}

		if ($row = $result->fetch_assoc()) {
			$customer_info['customer_id']= $row['customer_id'];
			$customer_info['first_name']= $row['first_name'];
		}
		return $customer_info;

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

	function makeReturnOrder($rental_id)
	{
		$query = "UPDATE rental ". 
				"SET return_date = NOW() ".
				"WHERE rental_id = ".$rental_id." ";

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

	function getMoviesNames()
	{
		$names = array();
		$query = "select F.title, min(I.inventory_id) as inventory_id ".
				"from inventory as I ".
				"inner join film as F on F.film_id = I.film_id ".
				"where inventory_in_stock(I.inventory_id) ".
				"group by F.title; ";

		if(!$this->connect()){
			return false;
		}
		$result = $this->getConnection()->query($query);

		//error in query
		if(!$result){
			return false;
		}

		while ($row = $result->fetch_assoc()) {
			$names[$row['inventory_id']] = $row['title'];
		}
		return $names;
	}

	function getMoviesNamesRented($customer)
	{
		$names = array();
		$query = "select F.title , min(rental_id) as rental_id ".
				"from rental ".
				"left join inventory as I using(inventory_id) ".
				"left join film as F on F.film_id = I.film_id ".
				"WHERE  rental.return_date IS NULL ".
				"and rental.customer_id = ".$customer." ".
				"group by F.title;";

		if(!$this->connect()){
			return false;
		}
		$result = $this->getConnection()->query($query);

		//error in query
		if(!$result){
			return false;
		}

		while ($row = $result->fetch_assoc()) {
			$names[$row['rental_id']] = $row['title'];
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