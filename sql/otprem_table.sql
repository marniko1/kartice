CREATE TABLE `otpremnice`(

	

	`R.B.` int(11) NOT NULL AUTO_INCREMENT,
	`DATUM` int(8) NOT NULL,
	`BR_OTPREMNICE` varchar(255) NOT NULL,
	`POCETNI_ALIAS` int(10) NOT NULL,
	`ZAVRSNI_ALIAS` int(10) NOT NULL,
	`IZLAZ_LOKACIJA` varchar(255) NOT NULL,
	`IZLAZ_TIP` varchar(255) NOT NULL,
	`KOLICINA` int(6) NOT NULL,
	`SKART` int(10) DEFAULT NULL,
	`OTPREMNICU_SASTAVIO` varchar(255) NOT NULL,
	`STAMPANO_PUTA` int(20) DEFAULT 0,
	`OTPREMNICU_STAMPAO` varchar(255) DEFAULT NULL,
	


	PRIMARY KEY (`DATUM`,`R.B.`),
	UNIQUE (`R.B.`)

)CHARACTER SET utf8 COLLATE utf8_unicode_ci;