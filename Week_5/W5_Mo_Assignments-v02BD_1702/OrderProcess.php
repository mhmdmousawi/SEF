<?php
/*
*	this page gets the variable needed from Order page
*	connect to MySQLWrap to insert rentinf information
*	if error return an error..
*	else return the reciept 
*/

if(isset($_POST['btn_submit'])){
	if(isset($_POST['film_title'])) {
		$film_title = $_POST['film_title'];
		if($film_title == "" || $film_title == "error"){
			echo "Please specify a film to be rented";
		}
	}

	if(!isset($_POST['rental_date']) || !isset($_POST['return_date']) ) {
		echo "Please specify start and return dates..";
	}else{
		$rental_date = $_POST['rental_date'];
		$return_date = $_POST['return_date'];
	}
}


?>

