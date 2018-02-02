<?php

function generisi_formu($polja, $submit_label, $hidden) {

	echo '<form method="post" action="process.php">';
	for ($i=0; $i < count($polja); $i++) {
		
		if ($polja[$i] == 'alias') {
			
			$type = 'text';
			$placeholder = $polja[$i];
			$value = '';
			$pattern = '[0-9]{10,10}';
			$oninput = "this.value=this.value.replace(/[^0-9]/g,'');";
			$title = 'Unesite ispravan format aliasa.';
			$onChange = '';
			$class = 'input';
			$onKeyPress = "return keyPressed(event)";
			$maxlength = '10';

		} else if ($polja[$i] == 'quantity') {
			
			$type = 'number';
			$placeholder = 'količina';
			$value = '';
			$pattern = '';
			$oninput = '';
			$title = '';
			$onChange = '';
			$class = 'input';
			$onKeyPress = '';
			$maxlength = '';
		} else if ($polja[$i] == 'description') {

			$opisi_skarta = array('Opis škarta','Card read fail','Ne čita Qprox','Nema alias','Loša štampa','Ostalo');

			echo '<select name="'.$polja[$i].'">';

			for ($i=0; $i < count($opisi_skarta); $i++) {

				echo '<option>'.$opisi_skarta[$i].'</option>';

			}

			echo '</select>';
			echo '<input type="submit" name="submit" value="'.$submit_label.'" class="btns">';
			break;
		} else if ($polja[$i] == 'exit_desc') {

			$opisi_izlaza = array('tip izlaza','personalizovane','nepersonalizovane','test');

			echo '<select id="'.$polja[$i].'" onchange="ChangeLocationList()" name="'.$polja[$i].'">';

			foreach ($opisi_izlaza as $opis) {
				
				echo '<option value="'.$opis.'">'.$opis.'</option>';
			}

			echo '</select>';
			echo '<select id="locDesc" name="locDesc"></select>';
			echo "<script type=\"text/javascript\">
				var exitType = {};
				exitType['personalizovane'] = ['prodajno mesto','BP-88','BP-15','BP-40','Jugocentar','Beograđanka','BP-9','BP-22','Skender Begova','Lasta','BP-63','Help Desk Bgđ','Help Desk Jgc'];
				exitType['nepersonalizovane'] = ['distributer','Alego','Štampa','Centrosinergija','Lasta','TOB'];
				exitType['test'] = ['test lokacija','backend test','menadžment promo','lanus test'];

				function ChangeLocationList() {
				    var exitDesc = document.getElementById(\"exit_desc\");
				    var locDesc = document.getElementById(\"locDesc\");
				    var selCard = exitDesc.options[exitDesc.selectedIndex].value;
				    while (locDesc.options.length) {
				        locDesc.remove(0);
				    }
				    var cards = exitType[selCard];
				    if (cards) {
				        var i;
				        for (i = 0; i < cards.length; i++) {
				            var card = new Option(cards[i], i);
				            locDesc.options.add(card);
				        }
				    }
				} 
			</script>";

			echo '<input type="submit" name="submit" value="'.$submit_label.'" class="btns">';

			break;
		}	else {
			
			$type = 'submit';
			$value = $submit_label;
			$pattern = '';
			$oninput = '';
			$title = '';
			$class = 'btns';
			$onKeyPress = '';
			$maxlength = '';

		}
		
		
			echo '<input type="'.$type.'" name="'.$polja[$i].'" placeholder="'.$placeholder.'" value="'.$value.'" pattern="'.$pattern.'" oninput="'.$oninput.'" title="'.$title.'" class="'.$class.'" onKeyPress="'.$onKeyPress.'" maxlength="'.$maxlength.'">';
		
	}
	echo '<input type="text" name="'.$hidden.'" style="visibility: hidden;">';
	echo '</form>';
	global $msg;
	if (isset($_GET['msg'])){
		if ($_GET['msg'] < 500 ) {
		echo $msg;
		}
	}
}



function month_switch($mesec) {

	switch ($mesec) {
		case 'januar':
			$mesec = '01';
			break;
		case 'februar':
			$mesec = '02';
			break;
		case 'mart':
			$mesec = '03';
			break;
		case 'april':
			$mesec = '04';
			break;
		case 'maj':
			$mesec = '05';
			break;
		case 'jun':
			$mesec = '06';
			break;
		case 'jul':
			$mesec = '07';
			break;
		case 'avgust':
			$mesec = '08';
			break;
		case 'septembar':
			$mesec = '09';
			break;
		case 'oktobar':
			$mesec = '10';
			break;
		case 'novembar':
			$mesec = '11';
			break;
		
		default:
			$mesec = '12';
			break;
	}
	return $mesec;
}


function select($izlaz = 'nije izlaz') {
	
	$meseci = array('-mesec-','januar','februar','mart','april','maj','jun','jul','avgust','septembar','oktobar','novembar','decembar');
	$dani = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
	

	// Select OD

	echo '<form action="" method="POST">
			<div class="select_bar">
				<label>Od: </label>
				<select name="year">';
		for ($i=date('Y'); $i >= (date('Y')-5); $i--) { 
		 	echo '<option>'.$i.'</option>';
		 } 
	echo '</select>
		<select id="month" onchange="ChangeLocationList1()" name="month">';

	foreach ($meseci as $mesec) {
				if ($mesec == 'april' || $mesec == 'jun' || $mesec == 'septembar' || $mesec == 'novembar') {
					$broj_dana = 30;
				} else if ($mesec == 'februar' && date("L") == 1) {
					$broj_dana = 29;
				} else if ($mesec == 'februar') {
					$broj_dana = 28;
				} else {
					$broj_dana = 31;
				}
				echo '<option value="'.$broj_dana.'">'.$mesec.'</option>';
	}

	echo '</select>';
	echo '<input type="hidden" name="mesec" id="make_text">';

	echo '<select id="day" name="day"></select>

		<script type="text/javascript">
			var number_of_days = {};
			number_of_days[\'31\'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
			number_of_days[\'30\'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];
			number_of_days[\'29\'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29];
			number_of_days[\'28\'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28];

			function ChangeLocationList1() {

				var exitDesc_text = document.getElementById("month");
    
    			document.getElementById(\'make_text\').value = exitDesc_text.options[exitDesc_text.selectedIndex].text;

			    var month = document.getElementById("month");
			    var day = document.getElementById("day");
			    var selCard = month.options[month.selectedIndex].value;
			    while (day.options.length) {
			        day.remove(0);
			    }
			    var cards = number_of_days[selCard];
			    if (cards) {
			        var i;
			        for (i = 0; i < cards.length; i++) {
			            var card = new Option(cards[i], i);
			            day.options.add(card);
			        }
			    }
			} 
		</script>';

		// Select DO

	echo '<label><br>Do: </label>
		<select name="year1">';
		for ($i=date('Y'); $i >= (date('Y')-5); $i--) { 
		 	echo '<option>'.$i.'</option>';
		 } 
	echo '</select>
		<select id="month1" onchange="ChangeLocationList2()" name="month1">';

	foreach ($meseci as $mesec) {
				if ($mesec == 'april' || $mesec == 'jun' || $mesec == 'septembar' || $mesec == 'novembar') {
					$broj_dana = 30;
				} else if ($mesec == 'februar' && date("L") == 1) {
					$broj_dana = 29;
				} else if ($mesec == 'februar') {
					$broj_dana = 28;
				} else {
					$broj_dana = 31;
				}
				echo '<option value="'.$broj_dana.'">'.$mesec.'</option>';
	}

	echo '</select>';
	echo '<input type="hidden" name="mesec1" id="make_text1">';
	echo '<select id="day1" name="day1"></select>

		<script type="text/javascript">
			var number_of_days1 = {};
			number_of_days1[\'31\'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
			number_of_days1[\'30\'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30];
			number_of_days1[\'29\'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29];
			number_of_days1[\'28\'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28];

			function ChangeLocationList2() {

				var exitDesc_text = document.getElementById("month1");
    
    			document.getElementById(\'make_text1\').value = exitDesc_text.options[exitDesc_text.selectedIndex].text;

			    var month = document.getElementById("month1");
			    var day = document.getElementById("day1");
			    var selCard = month1.options[month1.selectedIndex].value;
			    while (day.options.length) {
			        day.remove(0);
			    }
			    var cards = number_of_days1[selCard];
			    if (cards) {
			        var i;
			        for (i = 0; i < cards.length; i++) {
			            var card = new Option(cards[i], i);
			            day.options.add(card);
			        }
			    }
			} 
		</script>		
		</div>';
	if ($izlaz != 'nije izlaz') {
		echo '
				<div class="type_holder">
				
					<input type="checkbox" name="tip_izlaza[]"  id="tip_izlaza_nep" value="&apos;nepersonalizovane&apos;" onclick="nepersoCh()" checked><label>nepersonalizovane</label><br>
					<div class="lokacija">
						<input type="checkbox" name="lokacija_izlaza[]" class="nepers" value="&apos;Alego&apos;" checked><label>Alego</label><br>
						<input type="checkbox" name="lokacija_izlaza[]" class="nepers" value="&apos;Centrosinergija&apos;" checked><label>Centrosinergija</label><br>
						<input type="checkbox" name="lokacija_izlaza[]" class="nepers" value="&apos;Štampa&apos;" checked><label>Štampa</label><br>
						<input type="checkbox" name="lokacija_izlaza[]" class="nepers" value="&apos;Lasta&apos;" checked><label>Lasta nepersonalizovane</label><br>
						<input type="checkbox" name="lokacija_izlaza[]" class="nepers" value="&apos;TOB&apos;" checked><label>TOB</label><br>
					</div>

				</div>

				<div class="type_holder">
				
					<input type="checkbox" name="tip_izlaza[]" id="tip_izlaza_pers" value="&apos;personalizovane&apos;" onclick="persoCh()" checked><label>personalizovane</label><br>
					<div class="lokacija">			
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;BP-88&apos;" checked><label>BP-88</label><br>
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;BP-15&apos;" checked><label>BP-15</label><br>
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;BP-40&apos;" checked><label>BP-40</label><br>
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;Jugocentar&apos;" checked><label>Jugocentar</label><br>									
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;Beograđanka&apos;" checked><label>Beograđanka</label><br>
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;Lasta&apos;" checked><label>Lasta personalizovane</label><br>		
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;BP-9&apos;" checked><label>BP-9</label><br>		
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;BP-22&apos;" checked><label>BP-22</label><br>		
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;Skender Begova&apos;" checked><label>Skender Begova</label><br>
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;Help Desk bgđ&apos;" checked><label>Help Desk bgđ</label><br>
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;Help Desk jgc&apos;" checked><label>Help Desk jgc</label><br>
						<input type="checkbox" class="pers" name="lokacija_izlaza[]" value="&apos;BP-63&apos;" checked><label>BP-63</label><br>
					</div>				
				
				</div>

				<div class="type_holder">
					<input type="checkbox" name="tip_izlaza[]" id="tip_izlaza_test" value="&apos;test&apos;" onclick="testCh()" checked><label>Test</label><br>
					<div class="lokacija">			
						<input type="checkbox" class="testCh" name="lokacija_izlaza[]" value="&apos;BackEnd-test&apos;" checked><label>BackEnd</label><br>
						<input type="checkbox" class="testCh" name="lokacija_izlaza[]" value="&apos;Lanus-test&apos;" checked><label>Lanus</label><br>
						<input type="checkbox" class="testCh" name="lokacija_izlaza[]" value="&apos;Menadžment-promo&apos;" checked><label>Menadžment</label><br>
					</div>
				</div>';
	}
	echo	'<input type="submit" name="submit_pretraga_ulaza" value="Potvrdi">
		</form>';
	

}


function pretraga ($datum_pretrage, $connection, $msgs, $izlaz) {
	echo '<div class="perso_check">';
	if (isset($_POST['submit_pretraga_ulaza'])) {
		if (!empty($_POST['month']) && isset($_POST['day']) && !empty($_POST['month1']) && isset($_POST['day1'])) {
		
			$godina = $_POST['year'];
			$mesec = $_POST['mesec'];
			$dan = '0'.($_POST['day'] + 1);
			$mesec_number = month_switch($mesec);

			$godina1 = $_POST['year1'];
			$mesec1 = $_POST['mesec1'];
			$dan1 = '0'.($_POST['day1'] + 1);
			$mesec_number1 = month_switch($mesec1);


			if ($izlaz == 'izlaz' && (isset($_POST['tip_izlaza']) || isset($_POST['lokacija_izlaza']))) {
				if (isset($_POST['tip_izlaza'])) {
					$tip_izlaza = '('.implode(',', $_POST['tip_izlaza']).')';
				}
				if (isset($_POST['lokacija_izlaza'])) {
					$lokacija_izlaza = '('.implode(',', $_POST['lokacija_izlaza']).')';
				}
			}

			if ($godina > $godina1 || $godina == $godina1 && $mesec_number > $mesec_number1 || $godina == $godina1 && $mesec == $mesec1 && $dan > $dan1) {
				$msg = $msgs[601];
			} else {

				$datum = '\''.$godina.'-'.$mesec_number.'-'.$dan.' 00:00:00\'';
				$datum1 = '\''.$godina1.'-'.$mesec_number1.'-'.$dan1.' 00:00:00\'';

				if (!isset($tip_izlaza) && !isset($lokacija_izlaza)) {
					

					$result = mysqli_query($connection, "SELECT DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), COUNT(*) FROM kartice WHERE $datum_pretrage between $datum and $datum1 group by DATE_FORMAT($datum_pretrage, '%d.%m.%Y.')");
					$row1 = mysqli_fetch_all($result);

					if (empty($row1)) {
						$msg = $msgs[600];
					}
				} else if (isset($tip_izlaza) && !isset($lokacija_izlaza)) {

					$result = mysqli_query($connection, "SELECT DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_LOKACIJA, IZLAZ_TIP, COUNT(*) FROM kartice WHERE (IZLAZ_TIP in $tip_izlaza) and ($datum_pretrage between $datum and $datum1) group by DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_TIP, IZLAZ_LOKACIJA");
					$row1 = mysqli_fetch_all($result);

				} else if (!isset($tip_izlaza) && isset($lokacija_izlaza)) {

					$result = mysqli_query($connection, "SELECT DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_LOKACIJA, IZLAZ_TIP, COUNT(*) FROM kartice WHERE (IZLAZ_LOKACIJA in $lokacija_izlaza) and ($datum_pretrage between $datum and $datum1) group by DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_TIP, IZLAZ_LOKACIJA");
					$row1 = mysqli_fetch_all($result);

				} else {

					$result = mysqli_query($connection, "SELECT DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_LOKACIJA, IZLAZ_TIP, COUNT(*) FROM kartice WHERE (IZLAZ_TIP in $tip_izlaza) and (IZLAZ_LOKACIJA in $lokacija_izlaza) and ($datum_pretrage between $datum and $datum1) group by DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_TIP, IZLAZ_LOKACIJA");
					$row1 = mysqli_fetch_all($result);
				}



					// if (isset($_POST['tip_izlaza'])) {
					// 	$tip_izlaza = '('.implode(',', $_POST['tip_izlaza']).')';
					// }
					// if (isset($_POST['lokacija_izlaza'])) {
					// 	$lokacija_izlaza = '('.implode(',', $_POST['lokacija_izlaza']).')';
					// }
					

					// $result = mysqli_query($connection, "SELECT DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_LOKACIJA, IZLAZ_TIP, COUNT(*) FROM kartice WHERE ((IZLAZ_TIP in $tip_izlaza) or (IZLAZ_LOKACIJA in $lokacija_izlaza)) and ($datum_pretrage between $datum and $datum1) group by DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_LOKACIJA, IZLAZ_TIP");
					// $result = mysqli_query($connection, "SELECT DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_LOKACIJA, IZLAZ_TIP, COUNT(*) FROM kartice WHERE $datum_pretrage between $datum and $datum1 group by DATE_FORMAT($datum_pretrage, '%d.%m.%Y.'), IZLAZ_LOKACIJA");
					

					if (empty($row1)) {
						$msg = $msgs[600];
					}
				
			}
		} else {
			$msg = $msgs[0];
		}
	
		if (isset($msg)) {
			echo $msg;
		}
	}
	if ($izlaz == 'izlaz') {
		select('izlaz');
	} else {
		select();
	}
	echo '</div>';


	// Stampanje tabele sa rezultatima pretrage

	if (!empty($row1) && isset($_POST['submit_pretraga_ulaza'])) {

		echo '<div id="index_table_wrapper';
		if ($izlaz=='izlaz') {
			echo '_izlaz';
		}
		switch ($izlaz) {
			case 'izlaz':
				$datum_naziv = 'Datum izlaza';
				break;
			
			case 'ulaz':
				$datum_naziv = 'Datum ulaza';
				break;

			default:
				$datum_naziv = 'Datum konfiguracije';
				break;
		}
		echo '" class="float_right">
				<table>
					<tr>';
					if (isset($tip_izlaza) || isset($lokacija_izlaza)) {
					echo '<th>'.$datum_naziv.'</th>
						<th>Lokacija izlaza</th>
						<th>Tip izlaza</th>
						<th>Količina</th>';
					} else {
						echo '<th>'.$datum_naziv.'</th>
							  <th>Količina</th>';
					}
				echo '</tr>';
				$ukupno = 0;
		foreach ($row1 as $value) {
			echo '<tr>';
			foreach ($value as $val) {
				echo '<td>'.$val.'</td>';
			}
			if (isset($tip_izlaza) || isset($lokacija_izlaza)) {
				$ukupno += $value[3];
				$colspan = 3;
			} else {
				$ukupno += $value[1];
				$colspan = 1;
			}
			echo '</tr>';
		}
		echo '<tr><td colspan="'.$colspan.'"><b>UKUPNO</b></td><td><b>'.$ukupno.'</b></td></tr>';
		echo '</table></div>';
		// var_dump($row1);
		// echo $tip_izlaza;
		// echo $lokacija_izlaza;
		// echo $ukupno;
	}
}