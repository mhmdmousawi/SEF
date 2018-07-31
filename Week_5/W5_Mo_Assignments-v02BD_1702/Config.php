
<?php

class Config {

	private $db_host ;
	private $db_user ;
	private $db_pass ;
	private $db_name ;


	function __construct()
	{
		$this->setDBHost('127.0.0.1'); 
		$this->setDBUser('phpuser');
		$this->setDBPassword('la2ya7obbi');
		$this->setDBName('sakila');
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
}


?>