<?php 

define('DBSERVER', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'kartice');


$connection = mysqli_connect(DBSERVER,DBUSER,DBPASS,DBNAME);