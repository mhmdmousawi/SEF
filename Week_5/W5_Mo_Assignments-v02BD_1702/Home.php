</!DOCTYPE html5>
<html>
<head>
	<title>Home</title>
</head>
<?php 
	session_start();
	$_SESSION["customer_name"]= "mhmd";
	$_SESSION["customer_id"]= 1;
?>
<body>
	<center>
		<h2> Hello <?php echo $_SESSION["customer_name"] ?> </h2>
		<p>Please choose whether you want to rent a DVD or return one: </p>
		<input type="button" value="Rent" onClick="document.location.href='Order.php'" />
		<input type="button" value="Return" onClick="document.location.href='Return.php'" />
	</center>
</body>
</html>