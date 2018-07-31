</!DOCTYPE html5>
<html>
<head>
	<title>Return</title>
</head>


<?php 
	require_once 'MySQLWrap.php';
	session_start();

	$wrap = new MySQLWrap();
	$moviesNames = $wrap->getMoviesNamesRented($_SESSION["customer_id"]);

	
	
?>
<body>
	<center>
		<h2> Hello <?php echo $_SESSION["customer_name"] ?> </h2>
		<form action="OrderProcess.php" method="POST">

			<p> Specify the film you want to return: </p>
			<select name="film_id">
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
			
			<!-- <p> Specify the return date of your rental: </p> -->
			<!-- <input type="date" name="return_date" min="2018-07-31" max="2018-12-31" required> -->
			<br><br>
			<button type="submit" name="btn_submit_return">Return Film</button>

		</form>
	</center>
</body>
</html>
