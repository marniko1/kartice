<?php
if (isset($_COOKIE['korisnik'])) {
	include 'includes/header.php';

	if ($_COOKIE['privilege'] == 'admin') {
		$polja = array('alias','quantity','submit');
		generisi_formu($polja, "Konfiguriši kartice", "ghost_konfiguracija");

		echo "<hr>";
	}
	pretraga('VREME_PROMENE_OPISA', $connection, $msgs, 'konfiguracija');
	
	echo "</div>";
	include 'includes/footer.php';
} else {
	header("Location: index.php");
}