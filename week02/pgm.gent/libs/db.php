<?php

$dsn = 'mysql:dbname=pgm;host=127.0.0.1;port=3306';
$user = 'root';
$password = 'secret';

$db = new PDO($dsn, $user, $password);

/* Onderstaande enkel in development */
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

