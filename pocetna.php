<?php
if (isset($_COOKIE['korisnik'])) {
	include 'includes/header.php';
	?>		<div id="index_table_wrapper">
				<table>
					<tr>
						<th>Ukupno stanje</th>
						<th>Konfigurisane</th>
						<th>Nekonfigurisane</th>
						<th>Škart</th>
						<th>Raspoložive</th>
					</tr>
					<tr>
						<?php

							$ukupno = mysqli_query($connection, "SELECT `OPIS` FROM kartice WHERE `IZLAZ_LOKACIJA` IS NULL");
							$ukupno_kart = mysqli_num_rows($ukupno);

							$konfigurisano = mysqli_query($connection, "SELECT `OPIS` FROM kartice WHERE OPIS != 'nekonfigurisana' AND `IZLAZ_LOKACIJA` IS NULL");
							$konfigurisano_kart = mysqli_num_rows($konfigurisano);

							$nekonfigurisano = mysqli_query($connection, "SELECT `OPIS` FROM kartice WHERE OPIS = 'nekonfigurisana'");
							$nekonfigurisano_kart = mysqli_num_rows($nekonfigurisano);

							$skart = mysqli_query($connection, "SELECT `OPIS` FROM kartice WHERE OPIS = 'skart' AND `IZLAZ_LOKACIJA` IS NULL");
							$skart_kart = mysqli_num_rows($skart);

							$raspolozivo = $konfigurisano_kart-$skart_kart;

							echo '<td>' . $ukupno_kart . '</td>';
							echo '<td>' . $konfigurisano_kart . '</td>';
							echo '<td>' . $nekonfigurisano_kart . '</td>';
							echo '<td>' . $skart_kart . '</td>';
							echo '<td>' . $raspolozivo . '</td>';
						?>
					</tr>
				</table>
			</div>
			<hr>
			<h4>Traži karticu po aliasu:</h4>
			<form method="post" action="">
				<input type="text" name="alias" placeholder="alias" value="" maxlength="10" onKeyPress="return keyPressed_pocetna(event)" pattern="[0-9]{10,10}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" title="Unesite ispravan format aliasa.">
				<input type="submit" name="submit_search_alias" value="Traži" class="btns">
			</form>
			
	<?php 
	if (isset($_POST['submit_search_alias']) && !empty($_POST['alias'])) {
		if (isset($_POST['alias'])) {
			
			$alias = $_POST['alias'];

			$result = mysqli_query($connection, "SELECT * FROM kartice WHERE ALIAS = $alias");
			$row = mysqli_fetch_assoc($result);

			if ($row) {
				echo '<div id="index_table_wrapper"><table><tr>';
				foreach ($row as $key => $value) {
					if ($value != null) {
						echo '<th>'.implode(' ',explode('_',ucfirst(strtolower($key)))).'</th>';
					}
				}
				echo '</tr><tr>';
				foreach ($row as $key => $value) {
					if ($value != null) {
						echo '<td>'.$value.'</td>';
					}
				}
				echo '</tr></table></div>';
			} else {
				echo 'Podaci za uneti alias ne postoje u bazi.';
			}
		}
	}
	include 'includes/footer.php';
} else {
	header("Location: index.php");
}


