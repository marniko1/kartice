<?php

// Process for izlaz.php


if (isset($_POST['ghost_izlaz'])) {

	if (isset($_POST['submit']) && $_POST['alias'] != null && $_POST['quantity'] != null && $_POST['exit_desc'] != 'tip izlaza' && $_POST['locDesc'] != null) {

		$alias = $_POST['alias'];
		$quantity = $_POST['quantity'];
		$exit_desc = $_POST['exit_desc'];
		$locDesc = $_POST['locDesc'];

		if ($exit_desc == 'personalizovane') {
			switch ($locDesc) {
			case '0':
				$locDesc = 'BP-88';
				break;
			case '1':
				$locDesc = 'BP-15';
				break;
			case '2':
				$locDesc = 'BP-40';
				break;
			case '3':
				$locDesc = 'Jugocentar';
				break;
			case '4':
				$locDesc = 'Beograđanka';
				break;
			case '5':
				$locDesc = 'BP-9';
				break;
			case '6':
				$locDesc = 'BP-22';
				break;
			case '7':
				$locDesc = 'Skender Begova';
				break;
			case '8':
				$locDesc = 'Lasta';
				break;
			case '9':
				$locDesc = 'BP-63';
				break;
			case '10':
				$locDesc = 'Help Desk Bgđ';
				break;
			default:
				$locDesc = 'Help Desk Jgc';
				break;
			}
		}

		if ($exit_desc == 'nepersonalizovane') {
			switch ($locDesc) {
			case '0':
				$locDesc = 'Alego';
				break;
			case '1':
				$locDesc = 'Štampa';
				break;
			case '2':
				$locDesc = 'Centrosinergija';
				break;
			case '3':
				$locDesc = 'Lasta';
				break;
			default:
				$locDesc = 'TOB';
				break;
			}
		}

		if ($exit_desc == 'test') {
			switch ($locDesc) {
			case '0':
				$locDesc = 'Backend-test';
				break;
			case '1':
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
			    
			    } else {

			    	header("Location: izlaz.php?msg=403");

			    	break 2;

			    }
			}
		
		    $alias_group = '(' . rtrim((implode($query_parts)),",") . ')';

		    $alias_otprem_start = $_POST['alias'];
		    $alias_otprem_end = rtrim($query_parts[$quantity-1],",");

		    $result = mysqli_query($connection, "SELECT MAX(`R.B.`) AS RB FROM otpremnice WHERE `DATUM`=$date");
			$row = mysqli_fetch_assoc($result);
			$max_br = $row['RB'];
			$result1 = mysqli_query($connection, "SELECT BR_OTPREMNICE, IZLAZ_LOKACIJA, POCETNI_ALIAS FROM otpremnice WHERE `R.B.`=$max_br");
			$row1 = mysqli_fetch_assoc($result1);

			if ($row1['POCETNI_ALIAS'] != $alias_otprem_start) {

				if (!$row) {
					$br = 1;
				} else if ($locDesc!=$row1['IZLAZ_LOKACIJA']){
					$br = (substr($row1['BR_OTPREMNICE'], -1)+1);
				} else {
					$br = substr($row1['BR_OTPREMNICE'], -1);
				}
				$data_num = date('dmY');
				$br_otpremnice = $data_num . $br;
				

			    $query = "INSERT INTO `otpremnice` (DATUM,BR_OTPREMNICE,POCETNI_ALIAS,ZAVRSNI_ALIAS,IZLAZ_LOKACIJA,IZLAZ_TIP,KOLICINA) VALUES ($date,$br_otpremnice,$alias_otprem_start,$alias_otprem_end,'$locDesc','$exit_desc',$quantity)";
			    $result = mysqli_query($connection, $query);

			    if ($skart != null) {
			    	$query_skart = "UPDATE `otpremnice` SET SKART = $skart WHERE POCETNI_ALIAS = $alias_otprem_start";
			    	$result_skart = mysqli_query($connection, $query_skart);
			    }
			    // $query = "UPDATE `kartice` SET IZLAZ_TIP='$exit_desc', IZLAZ_LOKACIJA='$locDesc', IZLAZ_VREME='$date' WHERE ALIAS IN $alias_group";
			    // $result = mysqli_query($connection, $query);

			    // if ($result) {
			    // 	header("Location: izlaz.php?msg=400");
			    // } else {
			    // 	header("Location: izlaz.php?msg=407");
			    // }

			    header("Location: izlaz.php?msg=408");
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