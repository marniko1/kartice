<?php
if (isset($_COOKIE['korisnik'])) {
	include 'includes/header.php';
	if ($_COOKIE['privilege'] == 'admin') {
		$polja = array('alias','quantity','exit_desc','submit');
		generisi_formu($polja, "Dodaj u otpremnicu", "ghost_izlaz");



		echo '<hr>';

		 	date_default_timezone_set('Europe/Belgrade');
		 	$date = date('dmY');

		 	$max = mysqli_query($connection, "SELECT MAX(`R.B.`) AS RB FROM otpremnice");
			$row_max = mysqli_fetch_assoc($max);
			$max_br = $row_max['RB'];

			if ($max_br) {
		 
				$result_stampano_puta = mysqli_query($connection, "SELECT `STAMPANO_PUTA` FROM otpremnice WHERE `R.B.`=$max_br");
				$row_stampano_puta = mysqli_fetch_assoc($result_stampano_puta);

				if ($row_stampano_puta['STAMPANO_PUTA'] == 0) {

					$podaci = mysqli_query($connection, "SELECT BR_OTPREMNICE, IZLAZ_LOKACIJA, IZLAZ_TIP, KOLICINA  FROM otpremnice WHERE `R.B.`=$max_br");
					$row_podaci = mysqli_fetch_assoc($podaci);
					$br_otpremnice = $row_podaci['BR_OTPREMNICE'];
					$naziv_primaoca = $row_podaci['IZLAZ_LOKACIJA'];
					$izlaz_tip = $row_podaci['IZLAZ_TIP'];
					$datum = date('d.m.Y.');				

					$pocetni_aliasi = mysqli_query($connection, "SELECT POCETNI_ALIAS FROM otpremnice WHERE `BR_OTPREMNICE`=$br_otpremnice");
					$niz_pocetnih_aliasa = mysqli_fetch_all($pocetni_aliasi);

					$zavrsni_aliasi = mysqli_query($connection, "SELECT ZAVRSNI_ALIAS FROM otpremnice WHERE `BR_OTPREMNICE`=$br_otpremnice");
					$niz_zavrsnih_aliasa = mysqli_fetch_all($zavrsni_aliasi);

					$kolicine = mysqli_query($connection, "SELECT KOLICINA FROM otpremnice WHERE `BR_OTPREMNICE`=$br_otpremnice");
					$niz_kolicina = mysqli_fetch_all($kolicine);

					echo '
					<div class="btn_holder">
						<form action="" method="post">
					  		<input type="submit" name="submit" value="Štampaj otpremnicu" onClick="window.print()" class="btns">
					  	</form>
					  	<form action="process.php" method="post">
					  		<input type="submit" name="submit_potvrdi_i_stampaj" value="Potvrdi izlaz i štampaj otpremnicu" onClick="window.print()" class="btns">
					  		<input type="submit" name="submit_potvrdi_bez_stampe" value="Potvrdi izlaz" class="btns">
					  	</form>';
				echo '<form action="process.php" method="post">			
						<input type="submit" name="reset" value="Resetuj otpremnicu" class="btns">
					</form>';
			  	
			 		echo '</div>
					<div id="otpremnica">
							<div id="podaci_firme">
								<h5>APEX SOLUTION TECHNOLOGY DOO</h5>
								<p>Makenzijeva br. 24</p>
								<p>11 000 Beograd, Srbija</p>
								<p>Matični Broj: 20514841</p>
								<p>PIB: 106037154</p>
								<p>Šifra Delatnosti: 7022</p>
								<p>Tekući Račun: 340-11005053-79, Erste Bank</p>
						  	</div>
						  	<hr>

						  	<div id="naziv_posiljaoca">
						  		<p><b>Naziv pošiljaoca:</b> Apex Solution Technology doo, Magacin: Makenzijeva 24</p>
						  	</div>
						  	<div id="naziv_primaoca">
						  		<p><b>Naziv primaoca:</b> ' . $naziv_primaoca . '</p>
						  	</div>
						  	<div class="clearfix"></div>
						  	<div id="datum">
						  		<p><b>Datum:</b>' . $datum . '</p>
						  	</div>
						  	<div class="clearfix"></div>
						  	<div id="naslov">
						  		<h4>O T P R E M N I C A br. </h4><span id="br_otpremnice">' . $br_otpremnice . '</span>
						  	</div>
						  	<div id="table">
							  	<table>
							  		<tr rowspan="2">
								  		<th>Redni<br>broj</th>
								  		<th colspan="13">Alias</th>
								  		<th>Jedinica<br>mere</th>
								  		<th colspan="2">Količina</th>
							  		</tr>';
							  		$i = 0;
							  		foreach ($niz_pocetnih_aliasa as $pocetni_alias) {

							  			$skart = mysqli_query($connection, "SELECT SKART FROM otpremnice WHERE `POCETNI_ALIAS`=$pocetni_alias[0]");
										$skart_kartica = mysqli_fetch_assoc($skart);
										// $niz_skart_kartica = mysqli_fetch_all($skart);
							  			
							  			echo '<tr>';
							  			echo '<td>'.($i+1).'</td>';
							  			if ($niz_kolicina[$i][0] == 1) {
							  				echo '<td class="otprem_aliasi" colspan="13"> '.$pocetni_alias[0].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							  			} else {
							  				echo '<td class="otprem_aliasi" colspan="13">Od '.$pocetni_alias[0].' do '.$niz_zavrsnih_aliasa[$i][0];
							  			}
							  			if ($skart_kartica['SKART'] != null) {
							  				
							  				echo ' fali: ';							  				
							  				echo $skart_kartica['SKART'];
							  				
							  			}
							  			echo '</td>';
							  			echo '<td>kom.</td>';
							  			
							  			echo '<td>'.$niz_kolicina[$i][0].'</td>';
							  			
							  			echo '</tr>';
							  			$i++;
							  		}			  		
								  	echo '<tr>
								  			<td>'.($i+1).'</td>
								  			<td colspan="13"><b>UKUPNO<b></td>
								  			<td><b>kom.</b></td>
								  			<td>';
								  			$ukupno = 0;
								  			foreach ($niz_kolicina as $kolicina) {
								  				$ukupno += $kolicina[0];
								  			}
								  			echo '<b>' . $ukupno . '</b></td>
								  		</tr>
							  	</table>
						  	</div>
						  	<div class="potpis_posiljaoc">
						  	
						  	<span id="posiljaoc">Predao:_______________</span>
						  	</div>
						  	<div class="potpis_primaoc">
						  	
						  	<span id="primaoc">Primio:_______________</span>
						  	</div>
						  	<div class="clearfix"></div>

						  	<hr>
						  	<div class="otpremnica_footer">
						  		<p id="first_p">APEX SOLUTION TECHNOLOGY DOO BEOGRAD</p>
						  		<p id="second_p">Tel: +381 (0)11 381 20 00;   Fax: +381 (0)11 381 20 31</p>
						  	</div>
							  	
							  	
					</div>
					<div class="clearfix"></div><hr>';

				}
			}
	}
	pretraga('IZLAZ_VREME', $connection, $msgs, 'izlaz');
	echo '<div class="clearfix"></div>';
	include 'includes/footer.php';
} else {
	header("Location: index.php");
}