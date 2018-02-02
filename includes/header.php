<?php
include 'connect.php';
include 'lib/functiones.php';
include 'lookup.php';

global $msgs;
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
		<script type="text/javascript">
			function keyPressed_pocetna(e) {
				var key;      
				if(window.event)
				  key = window.event.keyCode; //IE
				else
				  key = e.which; //firefox      

				return (key != 13);
			}
			function keyPressed(event) {
				var x = event.keyCode;
			    if (x == 13) {
			        event.target.nextSibling.focus();
			        event.preventDefault();
			    }
			}
			function nepersoCh() {
				var checkPerso = document.getElementsByClassName('nepers');
				var checkButton = document.getElementById('tip_izlaza_nep');	
					if(checkButton.checked == true){				
					for (var i in checkPerso) {
	               		checkPerso[i].checked = true;
	            	}
	       		}else{
	       			for (var i in checkPerso) {
	       				checkPerso[i].checked = false;
	       			}
	       		}				
	       	}

	       	function persoCh() {
				var checkPerso = document.getElementsByClassName('pers');
				var checkButton = document.getElementById('tip_izlaza_pers');	
					if(checkButton.checked == true){				
					for (var i in checkPerso) {
	               		checkPerso[i].checked = true;
	            	}
	       		}else{
	       			for (var i in checkPerso) {
	       				checkPerso[i].checked = false;
	       			}
	       		}				
	       	}
	       	function testCh() {
				var checkPerso = document.getElementsByClassName('testCh');
				var checkButton = document.getElementById('tip_izlaza_test');	
					if(checkButton.checked == true){				
					for (var i in checkPerso) {
	               		checkPerso[i].checked = true;
	            	}
	       		}else{
	       			for (var i in checkPerso) {
	       				checkPerso[i].checked = false;
	       			}
	       		}				
	       	}
	</script>	
	</head>
	<body>
		<div class="logout">
			<form action="process.php" method="post" name="logout_form">
				<input type="submit" name="logout" value="Logout">
				<input type="text" name="ghost_logout" style="visibility: hidden; width: 1px;">
			</form>
			<span>Korisnik <?php echo $_COOKIE['korisnik']; ?></span>
		</div>
		<div class="naslovnaLinija">
			<img src="images/logo.png" class="logo">
			<h1>Aplikacija - magacin kartica</h1>
		</div>

		<nav class="nav">
			<?php
			global $li_privilege;

			if ($_COOKIE['privilege'] == 'member') {
				$li_privilege = 'li_member';
			} else {
				$li_privilege = 'li_admin';
			}
			?>
			<ul>
				<li class=" <?php echo $li_privilege; ?> "><a href="pocetna.php" id="pocetna">Početna</a></li>
				<li class=" <?php echo $li_privilege; ?> "><a href="ulaz.php" id="ulaz">Ulaz</a></li>
				<li class=" <?php echo $li_privilege; ?> "><a href="konfiguracija.php" id="konfiguracija">Konfiguracija</a></li>
				<li class=" <?php echo $li_privilege; ?> "><a href="izlaz.php" id="izlaz">Izlaz</a></li>
				<?php 
				if ($_COOKIE['privilege'] == 'admin') { 
					echo '<li class="li_admin"><a href="skart.php" id="skart">Škart</a></li>';
				}
				?>
				<div class="clearfix"></div>
			</ul>
		</nav>

		<div class="main">