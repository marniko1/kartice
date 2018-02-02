<?php
if (isset($_COOKIE['korisnik'])) {
	include 'includes/header.php';

	$polja = array('alias','description','submit');
	generisi_formu($polja, "Potvrdi škart", "ghost_skart");

	echo '<hr><p>Prikaz škart kartica za zadati mesec i godinu.</p>';
	?>
		<form method="post" action="">
			<label>Izaberi godinu: </label>
			<select name="year">
				<?php
				for ($i=date('Y'); $i >= (date('Y')-5); $i--) { 
				 	echo '<option>'.$i.'</option>';
				 } 
				?>
			</select>
			<label>Izaberi mesec: </label>
			<select name="month">
				<?php
				for ($i=1; $i <= 12; $i++) { 
					echo '<option>'.$i.'</option>';
				}
				?>
			</select>
			<input type="submit" name="submit" value="Prikaži škart kartice" class="btns">
		</form>

	<?php


	if (isset($_POST['submit']) && $_POST['year'] != null && $_POST['month'] != null) {

		$year = $_POST['year'];
		$month = $_POST['month'];

		$result = mysqli_query($connection, "SELECT * FROM kartice WHERE OPIS = 'skart' AND IZLAZ_LOKACIJA IS NULL AND YEAR(VREME_PROMENE_OPISA) = $year AND MONTH(VREME_PROMENE_OPISA) = $month");
		$skart_niz = mysqli_fetch_all($result);

		if ($skart_niz) {
			echo '<div class="skart_tabela1"><table>
					<tr>
						<th>Datum ulaska</th>
						<th>Serijski broj</th>
						<th>Napomena</th>
						<th>Datum konfiguracije</th>
					</tr>';
			foreach ($skart_niz as $skart) {
				echo '<tr>';
				foreach ($skart as $key => $value) {
					if ($value != null && $value != 'skart' && $key != 0 && $key != 9) {
						echo '<td>'.$skart[$key].'</td>';
					}
				}
				echo '</tr>';
			}
			echo '</table></div>';
		} else {
			echo $msgs[502];
		}

	} else if (isset($_POST['submit'])) {
		
		echo $msgs[0];

	}
	echo '<hr>
		<div class="wrapper_zapisnik">
		<div class="btn_holder">
		<p>Pravljenje zapisnika o škartu.</p>';
	?>
		<form method="post" action="">
			<label>Izaberi godinu: </label>
			<select name="year1">
				<?php
				for ($i=date('Y'); $i >= (date('Y')-5); $i--) { 
				 	echo '<option>'.$i.'</option>';
				 } 
				?>
			</select>
			<label>Izaberi mesec: </label>
			<select name="month1">
				<?php
				for ($i=1; $i <= 12; $i++) { 
					echo '<option>'.$i.'</option>';
				}
				?>
			</select>
			<input type="submit" name="submit1" value="Sastavi zapisnik" class="btns">
		</form>

	<?php
	if (isset($_GET['msg'])){
		if ($_GET['msg'] >= 500 && $_GET['msg'] < 600) {
			echo $msg;
		}
	}
	if (isset($_POST['submit1']) && $_POST['year1'] != null && $_POST['month1'] != null) {

		$year = $_POST['year1'];
		$month = $_POST['month1'];

		$result = mysqli_query($connection, "SELECT DATE_FORMAT(VREME_PROMENE_OPISA, '%d.%c.\'%y.'), ALIAS, SKART_OPIS FROM kartice WHERE OPIS = 'skart' AND IZLAZ_LOKACIJA IS NULL AND YEAR(VREME_PROMENE_OPISA) = $year AND MONTH(VREME_PROMENE_OPISA) = $month");
		$skart_niz = mysqli_fetch_all($result);
		$skart_ukupno = mysqli_num_rows($result);

		if ($skart_ukupno > 0) {
			echo '
				<form name="otpis_skarta" action="" method="post">
					<input type="submit" name="otpis_skarta_print" value="Štampaj zapisnik" onClick="window.print()" class="btns">
				</form>
				<form name="otpis_skarta" action="process.php" method="post">
					<input type="submit" name="otpis_skarta_submit" value="Otpiši škart" class="btns">
					<input type="submit" name="otpis_skarta_submit_and_print" value="Otpiši škart i štampaj zapisnik" onClick="window.print()" class="btns">
					<input type="text" name="ghost_otpis_skarta" style="visibility: hidden;">
				</form>
				</div>
				<div class="zapisnik">
				<div id="zapisnik_o_skartu">
					<h4 style="margin-top:45px">OBVEZNIK:  " APEX SOLUTION TECHNOLOGY " D.O.O.</h4>
					<h4>PIB : 106037154</h4>
					<h4>MESTO: Beograd, Glavni magacin</h4>

					<h3 class="sredina">ZAPISNIK O ŠKARTU</h3>
					<div id="table">
					<table>
						<tr>
							<th>r.b.</th>
							<th>Datum (dan i mesec)</th>
							<th>Serijski broj</th>
							<th>Napomena</th>
						</tr>';
						$niz_skart_aliasi = array();
						$i = 1;
						foreach ($skart_niz as $skart) {
							$niz_skart_aliasi [] = "(" . $skart[1] . "), ";
							echo '<tr>';
							echo '<td>'.$i.'</td>';
							$i++;
							foreach ($skart as $key => $value) {
								if ($key == 1) {
									echo '<td>0'.$value.'</td>';
								} else {
								echo '<td>'.$value.'</td>';		
								}				
							}
							echo '</tr>';
						}
						$skart_aliasi = implode($niz_skart_aliasi);
						$_SESSION['skart_aliasi'] = '(' . rtrim($skart_aliasi,", ") . ')';

					echo '<tr>
							<td colspan="3">UKUPNO</td>
							<td>'.$skart_ukupno.'</td>
						</tr>
					</table>
					</div>
					<h5 class="sredina">М.P.</h5>

					<h5 class = "potpisL"> Predao: _______________________</h5>
					<h5 class = "potpisD"> Primio: _______________________</h5>
					<div class = "clearfix"></div>
				
					<h4>У Beogradu, dana: '.date('d.m.Y.').'</h4>
				</div>
				</div>
			<div class="clearfix"></div>';
		} else {
			echo $msgs[502];
		}

	} else if (isset($_POST['submit1'])) {
		
		echo $msgs[0];

	}

	echo '</div><div class="clearfix"></div></div>';
	include 'includes/footer.php';
} else {
	header("Location: index.php");
}