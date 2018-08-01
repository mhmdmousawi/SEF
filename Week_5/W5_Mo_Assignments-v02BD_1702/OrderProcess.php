<?php

require_once 'MySQLWrap.php';

session_start();
$newSQLWrap = new MySQLWrap();
$inventory_id= "";
$customer_id= $_SESSION["customer_id"];
$staff_id = 2;

if (isset($_POST['btn_submit_login'])){

	if( isset($_POST['email']) ){
		
		
		$customer_info = $newSQLWrap->login($_POST['email']);

		if($customer_info){
		
			echo "<p> Login successfully .....customer_id: ".$customer_info['customer_id']."</p> <br>";

			$_SESSION["customer_id"] = $customer_info['customer_id'];
			$_SESSION["customer_name"] = $customer_info['first_name'];
			header('Location: '.'Home.php');

		}else {

			echo "<p> ERROR logging in!! </p> <br>";
			// $_SESSION["error_msg"] = "email_not_found";

			header('Location: '.'Login.php?error=email_not_found');
		}

	}

} else if (isset($_POST['btn_submit_logout'])){

	//invalidate session
	session_destroy();
	header('Location: '.'Login.php');

} else if(isset($_POST['btn_submit_register'])){

	header('Location: '.'Register.php');

} else if (isset($_POST['btn_submit_order'])) {
	
	if(isset($_POST['inventory_id'])) {
		
		$inventory_id = $_POST['inventory_id'];
		
		if($inventory_id == "" || $inventory_id == "error"){
			
			echo "<p> Please specify a film to be rented </p> <br>";
		}
	}

	$order_status = $newSQLWrap->makeRentalOrder($inventory_id,$customer_id,$staff_id);

	if($order_status){
		
		echo "<center>";
		echo "<p> Rented successfully </p> <br>";
		echo "<a href='Home.php'>Go back Home!</a>";
		echo "</center>";
	}else {

		echo "<p> ERROR not inserted successfully </p> <br>";
	}

} else if (isset($_POST['btn_submit_return'])) {

	if(isset($_POST['rental_id'])) {
		$rental_id = $_POST['rental_id'];
		if($rental_id == "" || $rental_id == "error"){
			echo "<p> Please specify a film to be returned </p> <br>";
		}
	}
	
	$order_status = $newSQLWrap->makeReturnOrder($rental_id);

	if($order_status){
		echo "<center>";
		echo "<p> Returned successfully </p> <br>";
		echo "<a href='Home.php'>Go back Home!</a>";
		echo "</center>";
	}else {
		echo "<p> ERROR!! film not returned </p> <br>";
	}

} 


?>

