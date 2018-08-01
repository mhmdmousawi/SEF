</!DOCTYPE html5>
<html>
<head>
	<title>Return</title>
</head>


<?php 

require_once 'MySQLWrap.php';
session_start();

if(!$_SESSION["customer_id"]){
	header('Location: '.'Login.php?error=dont_try');
}

$wrap = new MySQLWrap();
$moviesNames = $wrap->getMoviesNamesRented($_SESSION["customer_id"]);

?>
<body>
	<center>
		<h2> Hello <?php echo $_SESSION["customer_name"] ?> </h2>
		<form action="OrderProcess.php" method="POST">
			<button type="submit" name="btn_submit_logout">Logout</button>
			<p> Specify the film you want to return: </p>
			<select name="rental_id">
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
			
			<br><br>
			<button type="submit" name="btn_submit_return">Return Film</button>
		</form>
	</center>
</body>
</html>
