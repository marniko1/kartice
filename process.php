<?php
session_start();

include 'connect.php';

// PROCESS ZA index.php (login)

if (isset($_POST['ghost_login'])) {
	if (isset($_POST['login']) && !empty($_POST['user_name']) && !empty($_POST['password'])) {
		$user = $_POST['user_name'];
		$pass = $_POST['password'];


		$result = mysqli_query($connection, "SELECT user_name, password, korisnik, privilege from `login` where user_name='$user' and password = $pass");
		$row = mysqli_fetch_assoc($result);

		$privilege = $row['privilege'];
		$korisnik = $row['korisnik'];

		setcookie('korisnik', $korisnik, time() + 86400, "/");
		setcookie('privilege', $privilege, time() + 86400, "/");


		if ($row['user_name'] == $user && $row['password'] == $pass) {
			header("Location: pocetna.php");
		} else {
			header("Location: index.php?msg=1");
		}
	} else {
		header("Location: index.php?msg=0");
	}
}

// PROCESS ZA index.php (logout)

if (isset($_POST['ghost_logout'])) {
	if (isset($_POST['logout'])) {
		unset($_COOKIE['user']);
		unset($_COOKIE['privilege']);

		setcookie('korisnik', '', time() - 3600, "/");
		setcookie('privilege', '', time() - 3600, "/");

		header("Location: index.php");
	}
}

// PROCESS ZA ulaz.php

if (isset($_POST['ghost_ulaz'])) {
	if (isset($_POST['submit']) && !empty($_POST['alias']) && !empty($_POST['quantity'])) {
		$alias = $_POST['alias'];
		$quantity = $_POST['quantity'];

		$result = mysqli_query($connection, "SELECT OPIS from `kartice` where ALIAS='$alias'");
		$row = mysqli_fetch_assoc($result);

		$korisnik = "'".$_COOKIE['korisnik']."'";
		
		if (!$row['OPIS']) {

			$query_parts = array();
	    
		    for($x=1; $x<=$quantity; $x++){

		    	$result = mysqli_query($connection, "SELECT OPIS from `kartice` where ALIAS='$alias'");
				$row = mysqli_fetch_assoc($result);

				if (!$row['OPIS']) {
					
					$query_parts[] = "(" . $alias . ','.$korisnik."), ";
			    	$alias++;

				} 
				else {

					$_SESSION['alias'] = $alias;

					header("Location: ulaz.php?msg=101");

					break 2;
				}
			        
		    }



		    $alias_group = rtrim((implode($query_parts)),", ");

		    $query = "INSERT INTO `kartice` (ALIAS, ULAZ_NAPRAVIO) VALUES $alias_group";
		    $result = mysqli_query($connection, $query);
		    
		    if ($result) {
		    	header("Location: ulaz.php?msg=100");
		    } else {
		    	header("Location: ulaz.php?msg=103");
		    }
		    


		} else {
			header("Location: ulaz.php?msg=102");
		}
	} else if (isset($_POST['submit'])) {
		
		header("Location: ulaz.php?msg=0");
	}



// PROCESS ZA konfiguracija.php

} else if (isset($_POST['ghost_konfiguracija'])) {
	if (isset($_POST['submit']) && !empty($_POST['alias']) && !empty($_POST['quantity'])) {
	
		date_default_timezone_set('Europe/Belgrade');
		
		$alias = $_POST['alias'];
		$quantity = $_POST['quantity'];

		$korisnik = $_COOKIE['korisnik'];

		$date = date('Y-m-d H:i:s');

		$result = mysqli_query($connection, "SELECT OPIS from `kartice` where ALIAS='$alias'");
		$row = mysqli_fetch_assoc($result);


		if ($row['OPIS'] == 'nekonfigurisana') {

			$query_parts = array();
	    
		    for($x=1; $x<=$quantity; $x++){

		    	$result = mysqli_query($connection, "SELECT OPIS from `kartice` where ALIAS='$alias'");
				$row = mysqli_fetch_assoc($result);

		    	if ($row['OPIS'] == 'nekonfigurisana') {
		    		$alias = ltrim($alias, '0');
			        $query_parts[] = $alias . ",";
			    	$alias++;
		    	} else if ($row['OPIS'] == 'konfigurisana' || $row['OPIS'] == 'skart') {
					
					$_SESSION['alias'] = $alias;
					
					header("Location: konfiguracija.php?msg=203");
					
					break 2;

				} else {

					$_SESSION['alias'] = $alias;

					header("Location: konfiguracija.php?msg=204");

					break 2;
				}
		    }



		    $alias_group = '(' . rtrim((implode($query_parts)),",") . ')';

		    $query = "UPDATE `kartice` SET OPIS='konfigurisana', VREME_PROMENE_OPISA='$date', KONFIGURISAO='$korisnik' WHERE ALIAS IN $alias_group";
		    $result = mysqli_query($connection, $query);

		    header("Location: konfiguracija.php?msg=200");
			

			} else if ($row['OPIS'] == 'konfigurisana' || $row['OPIS'] == 'skart') {
					
				header("Location: konfiguracija.php?msg=201");

			} else {

				header("Location: konfiguracija.php?msg=202");
		}
	} else if (isset($_POST['submit'])) {

		header("Location: konfiguracija.php?msg=0");

	}
}


// PROCESS ZA skart.php

if (isset($_POST['ghost_skart'])) {

	if (isset($_POST['submit']) && !empty($_POST['alias']) && $_POST['description'] != 'Opis škarta') {
		date_default_timezone_set('Europe/Belgrade');
		$alias = $_POST['alias'];
		$description = $_POST['description'];

		$date = date('Y-m-d H:i:s');
		$korisnik = $_COOKIE['korisnik'];

		$result = mysqli_query($connection, "SELECT OPIS, IZLAZ_LOKACIJA from `kartice` where ALIAS='$alias'");
		$row = mysqli_fetch_assoc($result);


		if ($row['OPIS'] == 'konfigurisana' && $row['IZLAZ_LOKACIJA'] == null) {


			$query = "UPDATE `kartice` SET OPIS='skart', VREME_PROMENE_OPISA='$date', SKART_OPIS='$description', SKART_NAPRAVIO='$korisnik' WHERE ALIAS='$alias'";

			$result = mysqli_query($connection, $query);


			if ($result) {

				header("Location: skart.php?msg=300");

			} else {

				header("Location: skart.php?msg=301");
			}
		} else if ($row['OPIS'] == 'skart') {

			header("Location: skart.php?msg=303");

		} else if (!$row['OPIS']) {
			
			header("Location: skart.php?msg=304");

		} else if ($row['IZLAZ_LOKACIJA'] != null) {

			header("Location: skart.php?msg=305");
			
		} else {

			header("Location: skart.php?msg=302");

		}
	} else if (isset($_POST['submit'])) {
		
		header("Location: skart.php?msg=0");

	}
}


// PROCESS ZA izlaz.php OTPREMNICA


if (isset($_POST['ghost_izlaz'])) {

	if (isset($_POST['submit']) && !empty($_POST['alias']) && !empty($_POST['quantity']) && $_POST['exit_desc'] != 'tip izlaza' && !empty($_POST['locDesc'])) {

		$alias = $_POST['alias'];
		$quantity = $_POST['quantity'];
		$exit_desc = $_POST['exit_desc'];
		$_SESSION['exit_desc'] = $exit_desc;
		$locDesc = $_POST['locDesc'];
		$_SESSION['locDesc'] = $locDesc;

		if ($exit_desc == 'personalizovane') {
			switch ($locDesc) {
			case '1':
				$locDesc = 'BP-88';
				break;
			case '2':
				$locDesc = 'BP-15';
				break;
			case '3':
				$locDesc = 'BP-40';
				break;
			case '4':
				$locDesc = 'Jugocentar';
				break;
			case '5':
				$locDesc = 'Beograđanka';
				break;
			case '6':
				$locDesc = 'BP-9';
				break;
			case '7':
				$locDesc = 'BP-22';
				break;
			case '8':
				$locDesc = 'Skender Begova';
				break;
			case '9':
				$locDesc = 'Lasta';
				break;
			case '10':
				$locDesc = 'BP-63';
				break;
			case '11':
				$locDesc = 'Help Desk Bgđ';
				break;
			default:
				$locDesc = 'Help Desk Jgc';
				break;
			}
		}

		if ($exit_desc == 'nepersonalizovane') {
			switch ($locDesc) {
			case '1':
				$locDesc = 'Alego';
				break;
			case '2':
				$locDesc = 'Štampa';
				break;
			case '3':
				$locDesc = 'Centrosinergija';
				break;
			case '4':
				$locDesc = 'Lasta';
				break;
			default:
				$locDesc = 'TOB';
				break;
			}
		}

		if ($exit_desc == 'test') {
			switch ($locDesc) {
			case '1':
				$locDesc = 'Backend-test';
				break;
			case '2':
				$locDesc = 'Menadžment-promo';
				break;
			default:
				$locDesc = 'Lanus-test';
				break;
			}
		}

		date_default_timezone_set('Europe/Belgrade');
		$date = date('dmY');

		
		$result = mysqli_query($connection, "SELECT OPIS, IZLAZ_LOKACIJA from `kartice` where ALIAS='$alias'");
		$row = mysqli_fetch_assoc($result);

		// priprema niza kartica koje izlaze iz magacina
		if ($row['OPIS'] == 'konfigurisana' && $row['IZLAZ_LOKACIJA'] == null) {

			$query_parts = array();
			$skart = 0;
	    
		    for($i=1; $i<=$quantity; $i++){

		    	$result = mysqli_query($connection, "SELECT OPIS, IZLAZ_LOKACIJA from `kartice` where ALIAS='$alias'");
				$row = mysqli_fetch_assoc($result);

		    	if ($row['OPIS'] == 'konfigurisana' && $row['IZLAZ_LOKACIJA'] == null) {
		    		$alias = ltrim($alias, '0');
			        $query_parts[] = $alias . ",";
			    	$alias++;

			    } else if ($row['OPIS'] == 'skart') {
			    	
			    	$skart++;
			    	$i--;
					$alias ++;
			    
			    } else if ($row['OPIS'] == 'nekonfigurisana') {
			    	
			    	$_SESSION['alias'] = $alias;
			    	header("Location: izlaz.php?msg=401");

			    	break 2;
			    
			    } else if ($row['IZLAZ_LOKACIJA'] != null) {
			    	
			    	$_SESSION['alias'] = $alias;
			    	header("Location: izlaz.php?msg=402");

			    	break 2;
			    
			    } else if (!$row['OPIS']) {

			    	$_SESSION['alias'] = $alias;
			    	header("Location: izlaz.php?msg=407");

			    	break 2;

			    } else {

			    	header("Location: izlaz.php?msg=403");

			    	break 2;

			    }
			}
			
		    
		    // pripremanje otpremnice

		    $alias_otprem_start = $_POST['alias'];
		    $alias_otprem_end = rtrim($query_parts[$quantity-1],",");
		    $korisnik = $_COOKIE['korisnik'];

		    $result = mysqli_query($connection, "SELECT MAX(`R.B.`) AS RB FROM otpremnice WHERE `DATUM`=$date");
			$row = mysqli_fetch_assoc($result);
			$max_br = $row['RB'];
			$result1 = mysqli_query($connection, "SELECT BR_OTPREMNICE, IZLAZ_LOKACIJA, POCETNI_ALIAS, STAMPANO_PUTA FROM otpremnice WHERE `R.B.`=$max_br");
			$row1 = mysqli_fetch_assoc($result1);

			// da bi se sastavljala otpremnica neki od uslova ispod moraju da budu ispunjeni

			if (!$row1 || $row1['POCETNI_ALIAS'] != $alias_otprem_start && ($row1['STAMPANO_PUTA'] != 0 || $row1['IZLAZ_LOKACIJA'] == $locDesc)) {
				// pamćenje vrednosti stringa kroz sesiju

			    $alias_group = implode($query_parts);

			    if (!$_SESSION['alias_group']) {
			    	$_SESSION['alias_group'] = $alias_group;
			    } else {
			    	$other_parts = $_SESSION['alias_group'];		    	
			    	
			    	unset($_SESSION['alias_group']);
			    	$alias_group = $other_parts . $alias_group;

			    	$_SESSION['alias_group'] = $alias_group;		    	
			    }
			    // pravljenje broja otpremnice
				// ako u tabeli otpremnice nema unosa za trenutni datum
				if (!$row) {
					$br = 1;
				// ako postoje podaci za danasnji datum, a zadnji unos ima razlicitu lokaciju izlaza od unosa koji trenutno radimo
				} else if ($locDesc!=$row1['IZLAZ_LOKACIJA'] || $row1['STAMPANO_PUTA'] != 0){
					$br = (substr($row1['BR_OTPREMNICE'], -1)+1);
				// ako postoje podaci za danasnji datum, a zadnji unos ima istu lokaciju izlaza kao i unos koji trenutno radimo
				} else {
					$br = substr($row1['BR_OTPREMNICE'], -1);
				}
				$data_num = date('dmY');
				$br_otpremnice = $data_num . $br;
				
				// upis u tabelu otprmnice podataka za otpremnicu koja se pravi
			    $query = "INSERT INTO `otpremnice` (DATUM,BR_OTPREMNICE,POCETNI_ALIAS,ZAVRSNI_ALIAS,IZLAZ_LOKACIJA,IZLAZ_TIP,KOLICINA,OTPREMNICU_SASTAVIO) VALUES ($date,$br_otpremnice,$alias_otprem_start,$alias_otprem_end,'$locDesc','$exit_desc',$quantity,'$korisnik')";
			    $result = mysqli_query($connection, $query);
			    // ukoliko postoji skart kartica u rasponu aliasa za koji se pravi izlaz, unosi se koliko skarta postoji
			    if ($skart != null) {
			    	$query_skart = "UPDATE `otpremnice` SET SKART = $skart WHERE POCETNI_ALIAS = $alias_otprem_start";
			    	$result_skart = mysqli_query($connection, $query_skart);
			    }
			    

			    header("Location: izlaz.php?msg=408");
			    
			} else if ($row1['STAMPANO_PUTA '] == 0 && $row1['POCETNI_ALIAS'] != $alias_otprem_start) {
				header("Location: izlaz.php?msg=411");
			} else {
				header("Location: izlaz.php?msg=409");
			}
		
		} else if ($row['OPIS'] == 'konfigurisana' && $row['IZLAZ_LOKACIJA'] != null) {
			
			header("Location: izlaz.php?msg=404");

		} else if ($row['OPIS'] == 'nekonfigurisana') {

			header("Location: izlaz.php?msg=405");

		} else {

			header("Location: izlaz.php?msg=406");

		}

	} else if (isset($_POST['submit'])) {

		header("Location: izlaz.php?msg=0");

	}
}


// PROCESS ZA izlaz.php UNOS U BAZU

if (isset($_POST['submit_potvrdi_i_stampaj']) || isset($_POST['submit_potvrdi_bez_stampe'])) {


	$exit_desc = $_SESSION['exit_desc'];		
	$locDesc = $_SESSION['locDesc'];
	$alias_group = $_SESSION['alias_group'];
	$alias_group = '(' . rtrim($alias_group,",") . ')';
	$korisnik = $_COOKIE['korisnik'];
	unset($_SESSION['exit_desc']);
	unset($_SESSION['locDesc']);
	unset($_SESSION['alias_group']);
	unset($_SESSION['reset']);

	date_default_timezone_set('Europe/Belgrade');
	$date = date('Y-m-d H:i:s');

	if ($exit_desc == 'personalizovane') {
			switch ($locDesc) {
			case '1':
				$locDesc = 'BP-88';
				break;
			case '2':
				$locDesc = 'BP-15';
				break;
			case '3':
				$locDesc = 'BP-40';
				break;
			case '4':
				$locDesc = 'Jugocentar';
				break;
			case '5':
				$locDesc = 'Beograđanka';
				break;
			case '6':
				$locDesc = 'BP-9';
				break;
			case '7':
				$locDesc = 'BP-22';
				break;
			case '8':
				$locDesc = 'Skender Begova';
				break;
			case '9':
				$locDesc = 'Lasta';
				break;
			case '10':
				$locDesc = 'BP-63';
				break;
			case '11':
				$locDesc = 'Help Desk Bgđ';
				break;
			default:
				$locDesc = 'Help Desk Jgc';
				break;
			}
		}

		if ($exit_desc == 'nepersonalizovane') {
			switch ($locDesc) {
			case '1':
				$locDesc = 'Alego';
				break;
			case '2':
				$locDesc = 'Štampa';
				break;
			case '3':
				$locDesc = 'Centrosinergija';
				break;
			case '4':
				$locDesc = 'Lasta';
				break;
			default:
				$locDesc = 'TOB';
				break;
			}
		}

		if ($exit_desc == 'test') {
			switch ($locDesc) {
			case '1':
				$locDesc = 'Backend-test';
				break;
			case '2':
				$locDesc = 'Menadžment-promo';
				break;
			default:
				$locDesc = 'Lanus-test';
				break;
			}
		}

	// upis u tabelu kartice
	$query_kartice = "UPDATE `kartice` SET IZLAZ_TIP='$exit_desc', IZLAZ_LOKACIJA='$locDesc', IZLAZ_VREME='$date', IZLAZ_NAPRAVIO='$korisnik' WHERE ALIAS IN $alias_group";
    $result_query_kartice = mysqli_query($connection, $query_kartice);

    // upis u tabelu otpremnice napomene da je otpremnica stampana
    $result = mysqli_query($connection, "SELECT MAX(`R.B.`) AS RB FROM otpremnice");
	$row = mysqli_fetch_assoc($result);
	$max_br = $row['RB'];

	$result = mysqli_query($connection, "SELECT BR_OTPREMNICE FROM otpremnice WHERE `R.B.`=$max_br");
	$row = mysqli_fetch_assoc($result);
	$br_otpremnice = $row['BR_OTPREMNICE'];

	$query_otpremnica = "UPDATE `otpremnice` SET STAMPANO_PUTA=1, OTPREMNICU_STAMPAO='$korisnik' WHERE BR_OTPREMNICE=$br_otpremnice";
	$result = mysqli_query($connection, $query_otpremnica);



    if ($result_query_kartice) {
    	header("Location: izlaz.php?msg=400");
    } else {
    	header("Location: izlaz.php?msg=403");
    }
}


// PROCESS ZA izlaz.php RESET OTPREMNICE

if (isset($_POST['reset'])) {
	unset($_SESSION['reset']);
	unset($_SESSION['alias_group']);

	$result = mysqli_query($connection, "SELECT MAX(`R.B.`) AS RB FROM otpremnice");
	$row = mysqli_fetch_assoc($result);
	$max_br = $row['RB'];

	$result = mysqli_query($connection, "SELECT BR_OTPREMNICE, STAMPANO_PUTA FROM otpremnice WHERE `R.B.`=$max_br");
	$row = mysqli_fetch_assoc($result);
	$br_otpremnice = $row['BR_OTPREMNICE'];
	
	$stampano_puta = 'NULL';
	$query = "DELETE FROM otpremnice WHERE STAMPANO_PUTA=0";
	$result = mysqli_query($connection, $query);

	header("Location: izlaz.php?msg=410");
}

// PROCESS ZA skart.php OTPIS SKARTA

if (isset($_POST['ghost_otpis_skarta'])) {
	if (isset($_POST['otpis_skarta_submit']) || isset($_POST['otpis_skarta_submit_and_print'])) {

		date_default_timezone_set('Europe/Belgrade');
		$date = date('Y-m-d H:i:s');

		$korisnik = $_COOKIE['korisnik'];

		$skart_aliasi = $_SESSION['skart_aliasi'];
		unset($_SESSION['skart_aliasi']);

		$query_skart = "UPDATE `kartice` SET IZLAZ_TIP='skart', IZLAZ_LOKACIJA='otpis', IZLAZ_VREME='$date', IZLAZ_NAPRAVIO='$korisnik' WHERE ALIAS IN $skart_aliasi";
	    $result_query_skart = mysqli_query($connection, $query_skart);

	    if ($result_query_skart) {
	    	header("Location: skart.php?msg=500");
	    } else {
	    	header("Location: skart.php?msg=501");
	    }
	} else {
		header("Location: skart.php?msg=501");
	}
}