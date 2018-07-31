</!DOCTYPE html5>
<html>
<head>
	<title>Rental</title>
</head>


<?php 
	require_once 'Database.php';
	$conn = new Database();
	$moviesNames = $conn->getMoviesNames();

	session_start();
	$_SESSION["costumer_name"]= "mhmd";
	$_SESSION["costumer_id"]= "1";
?>
<body>
	<center>
		<h2> Hello <?php echo $_SESSION["costumer_name"] ?> </h2>
		<form action="OrderProcess.php" method="POST">

		<p> Specify the film you want to rent: </p>
			<select name="film_title">
				<option value="">-- Select Film --</option>
				<?php
						if($moviesNames == false){
							echo "<option value=\"error\"> Error connect to DB</option>";
						}
						foreach ($moviesNames as $key => $value) {
							echo "<option value=\"" . $value. "\">" . $value. "</option>";
						}
				?>
			</select>
			<p> Specify the rental date of your order: </p>
			<input type="date" name="rental_date" min="2018-07-31" max="2018-12-31" required>
			<br>
			<p> Specify the return date of your rental: </p>
			<input type="date" name="return_date" min="2018-07-31" max="2018-12-31" required>
			<br><br>
			<button type="submit" name="btn_submit">Order Film</button>

		</form>
	</center>
</body>
</html>