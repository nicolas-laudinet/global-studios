<?php

$dbHost = 'localhost';
$dbName = 'globalstudios';
$dbUser = 'root';
$dbPasswd = '';

$db = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPasswd);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 ?>
