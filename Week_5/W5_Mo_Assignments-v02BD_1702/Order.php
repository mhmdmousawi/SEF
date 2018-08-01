</!DOCTYPE html5>
<html>
<head>
	<title>Rental</title>
</head>


<?php 

require_once 'MySQLWrap.php';
session_start();

if(!$_SESSION["customer_id"]){
	header('Location: '.'Login.php?error=dont_try');
}

$wrap = new MySQLWrap();
$moviesNames = $wrap->getMoviesNames();

?>
<body>
	<center>
		<h2> Hello <?php echo $_SESSION["customer_name"] ?> !!</h2>

		<form action="OrderProcess.php" method="POST">
			<button type="submit" name="btn_submit_logout">Logout</button>
			<p> Specify the film you want to rent: </p>
			<select name="inventory_id">
				<option value="">-- Select Film --</option>
				<?php
						if($moviesNames == false){
							echo "<option value=\"error\"> Error connect to DB</option>";
						}
						foreach ($moviesNames as $key => $value) {
							echo "<option value=\"" . $key. "\">" . $value. "</option>";
						}
				?>
			</select>
			<br>
			<br>
			<button type="submit" name="btn_submit_order">Order Film</button>
		</form>
	</center>
</body>
</html>
