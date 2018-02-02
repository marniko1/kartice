CREATE TABLE `login`(	

	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_name` varchar(255) NOT NULL,
	`password` varchar(255) NOT NULL,
	`korisnik` varchar(255) NOT NULL,
	`privilege` varchar(255) NOT NULL,

	PRIMARY KEY (`id`),
	UNIQUE (`user_name`)

)CHARACTER SET utf8 COLLATE utf8_unicode_ci;