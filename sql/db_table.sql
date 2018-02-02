CREATE TABLE `kartice`(

	

	`R.B.` int(11) NOT NULL AUTO_INCREMENT,
	`DATUM` timestamp DEFAULT CURRENT_TIMESTAMP,
	`ALIAS` int(10) NOT NULL,
	`OPIS` varchar(255) DEFAULT 'nekonfigurisana',
	`ULAZ_NAPRAVIO` varchar(255) NOT NULL,
	`SKART_OPIS` varchar(255) DEFAULT NULL,
	`VREME_PROMENE_OPISA` TIMESTAMP DEFAULT NULL,
	`KONFIGURISAO` varchar(255) DEFAULT NULL,
	`SKART_NAPRAVIO` varchar(255) DEFAULT NULL,
	`IZLAZ_LOKACIJA` varchar(255) DEFAULT NULL,
	`IZLAZ_VREME` TIMESTAMP DEFAULT NULL,
	`IZLAZ_TIP` varchar(255) DEFAULT NULL,
	`IZLAZ_NAPRAVIO` varchar(255) DEFAULT NULL,
	`VREME_POSLEDNJE_PROMENE` TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,


	PRIMARY KEY (`R.B.`),
	UNIQUE (`ALIAS`)

)CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- update mytable set mycolumn = 
--     convert(binary convert(mycolumn using latin1) using utf8);

-- za mysql.ini - collation-server = utf8_unicode_ci
-- init-connect='SET NAMES utf8'
-- character-set-server = utf8