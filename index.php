<?php
if (!isset($_COOKIE['korisnik'])) {
	
	include 'lookup.php';

	if (isset($_GET['msg'])){
		$msg = $msgs[$_GET['msg']];
	}
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<title>KARTICE</title>
			<meta charset="utf-8">
			<link rel="stylesheet" type="text/css" href="css/main.css">
			<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">	
		</head>
		<body>
			<div class="naslovnaLinija">
				<img src="images/logo.png" class="logo">
				<h1>Aplikacija - magacin kartica</h1>
			</div>
			<div class="login_form">
				<form action="process.php" method="post">
					<label>Korisničko ime:</label>
					<input type="text" name="user_name">
					<div class="clearfix"></div>
					<label>Lozinka:</label>				
					<input type="password" name="password">
					<div class="clearfix"></div>				
					<input type="submit" name="login" value="Uloguj se">
					<input type="text" name="ghost_login" style="visibility: hidden;">
					<?php
					global $msg;
					if (isset($_GET['msg'])){
						echo $msg;
					}
					?>
				</form>
			</div>
		</body>
	</html>
<?php
} else {
	header("Location: pocetna.php");
}