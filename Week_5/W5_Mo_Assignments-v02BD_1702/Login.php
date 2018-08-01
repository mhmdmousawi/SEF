</!DOCTYPE html5>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<center>
	<h2>Login</h2>
	<h6>Please enter your email to login!</h6>
	<form action="OrderProcess.php" method="POST">
		<input type="email" name="email" placeholder="Please enter your email.." required>
		<br><br>
		<button type="submit" name="btn_submit_login">Login</button>
		<button type="submit" name="btn_submit_register">Register</button>
		<?php

			if(isset($_GET['error'])){
				if($_GET['error'] == "email_not_found"){
					echo "<br><p style='color:red'>Please enter a valid email..</p>";
				}else if($_GET['error']== "dont_try" ){
					echo "<br><p style='color:red'>Don't even try ;)</p>";
				}
			}
		?>

	</form>
	</center>
</body>
</html>