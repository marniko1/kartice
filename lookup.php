<?php
session_start();

$alias = 0;

if (isset($_SESSION['alias'])) {
	$alias = $_SESSION['alias'];
}
$msgs = array(
			0 => '<p style="color: red">' . "Nisu uneti svi podaci!" . '</p>',			
			1 => '<p style="color: red">' . "Pogrešno korisničko ime ili lozinka!" . '</p>',			
			100 => "Kartice uspešno ubačene u bazu.",
			101 => '<p style="color: red">' . "Kartice nisu ubačene u bazu. Kartice od aliasa $alias već postoje u bazi." . '</p>',
			102 => '<p style="color: red">' . "Kartice već postoje u bazi!" . '</p>',
			103 => '<p style="color: red">' . "Kartice nisu ubačene u bazu!" . '</p>',
			200 => "Uspešno konfigurisane kartice.",
			201 => '<p style="color: red">' . "Kartice su već konfigurisane!" . '</p>',
			202 => '<p style="color: red">' . "Kartice nisu konfigurisane. Kartice sa zadatim aliasom ne postoje u bazi!" . '</p>',
			203 => '<p style="color: red">' . "Kartice nisu konfigurisane. Kartice od aliasa  $alias  su već konfigurisane." . '</p>',
			204 => '<p style="color: red">' . "Kartice nisu konfigurisane. Kartice od aliasa $alias ne postoje u bazi." . '</p>',
			300 => "Uspešno promenjen opis kartice u škart.",
			301 => '<p style="color: red">' . "Neuspešna promena opisa u škart." . '</p>',
			302 => '<p style="color: red">' . "Neuspešna promena opisa u škart. Kartica nije konfigurisana!" . '</p>',
			303 => '<p style="color: red">' . "Kartica je već upisana kao škart!" . '</p>',
			304 => '<p style="color: red">' . "Kartica sa zadatim aliasom ne postoji u bazi!" . '</p>',
			305 => '<p style="color: red">' . "Neuspešna promena opisa u škart. Kartica sa zadatim aliasom je izdata!" . '</p>',
			400 => "Uspešno napravljen izlaz kartica.",
			401 => '<p style="color: red">' . "Nije moguće napraviti izlaz! Kartice od aliasa $alias nisu konfigurisane" . '</p>',
			402 => '<p style="color: red">' . "Nije moguće napraviti izlaz! Kartice od aliasa $alias su već izdate!" . '</p>',
			403 => '<p style="color: red">' . "Nije moguće napraviti izlaz!" . '</p>',
			404 => '<p style="color: red">' . "Nije moguće napraviti izlaz! Kartice sa zadatim aliasom su već izdate!" . '</p>',
			405 => '<p style="color: red">' . "Nije moguće napraviti izlaz! Kartice nisu konfigurisane!" . '</p>',
			406 => '<p style="color: red">' . "Nije moguće napraviti izlaz! Kartice sa zadatim aliasom ne postoje u bazi!" . '</p>',
			407 => '<p style="color: red">' . "Nije moguće napraviti izlaz! Kartice od aliasa $alias ne postoje u bazi." . '</p>',
			408 => '<p>' . "Uspešno dodato u otpremnicu." . '</p>',
			409 => '<p style="color: red">' . "Kartice su već dodate u otpremnicu!" . '</p>',
			410 => '<p style="color: red">' . "Uspešno resetovana otpremnica!" . '</p>',
			411 => '<p style="color: red">' . "Nije moguće pravljenje nove otpremnice. Otpremnica za prethodni izlaz je i dalje otvorena! Odraditi reset otpremnice ili potvrditi izlaz za otpremnicu koja je prikazana." . '</p>',
			500 => '<p>' . "Uspešno otpisan škart." . '</p>',
			501 => '<p style="color: red">' . "Neuspešan otpis škarta!" . '</p>',
			502 => '<p style="color: red">' . "Za dati period ne postoje škart kartice koje nisu otpisane." . '</p>',
			600 => '<p style="color: red">' . "Za dati period ne postoje podaci." . '</p>',
			601 => '<p style="color: red">' . "Nepravilno zadat period pretrage. Pocetni datum u intervalu mora biti manji od zavrsnog datuma." . '</p>',
		);