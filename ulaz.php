<?php
if (isset($_COOKIE['korisnik'])) {
	include 'includes/header.php';
	if ($_COOKIE['privilege'] == 'admin') {
		$polja = array('alias','quantity','submit');
		generisi_formu($polja, "Ubaci kartice u bazu", "ghost_ulaz");
		echo "<hr>";
	}
	pretraga('DATUM', $connection, $msgs, 'ulaz');
	
	echo "</div>";
	include 'includes/footer.php';
} else {
	header("Location: index.php");
}