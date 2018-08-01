</!DOCTYPE html5>
<html>
<head>
	<title>Home</title>
</head>
<?php 
session_start();

if(!$_SESSION["customer_id"]){
	header('Location: '.'Login.php?error=dont_try');
}

?>
<body>
	<center>
		<h2> Hello <?php echo $_SESSION["customer_name"] ?> </h2>
		<p>Please choose whether you want to rent a DVD or return one: </p>
		<input type="button" value="Rent" onClick="document.location.href='Order.php'" />
		<input type="button" value="Return" onClick="document.location.href='Return.php'" />
		<form action="OrderProcess.php" method="POST">
			<button type="submit" name="btn_submit_logout">Logout</button>
		</form>
	</center>
</body>
</html>