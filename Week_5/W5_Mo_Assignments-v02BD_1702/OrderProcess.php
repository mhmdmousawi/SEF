<?php
/*
*	this page gets the variable needed from Order page
*	connect to MySQLWrap to insert rentinf information
*	if error return an error..
*	else return the reciept 
*/
require_once 'MySQLWrap.php';

session_start();

$film_id= "";
$customer_id= $_SESSION["customer_id"];
$staff_id = 2;

if(isset($_POST['btn_submit'])){
	if(isset($_POST['film_id'])) {
		$film_id = $_POST['film_id'];
		if($film_id == "" || $film_id == "error"){
			echo "Please specify a film to be rented";
		}
	}

	echo $film_id . " ";
	echo $customer_id . " ";
	echo $staff_id . " ";

	$newSQLWrap = new MySQLWrap();
	$order_status = $newSQLWrap->makeRentalOrder($film_id,$customer_id,$staff_id);

	if($order_status){
		echo "inserted successfully";
	}else {
		echo "ERROR not inserted successfully";
	}

}


?>

