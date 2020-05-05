<?php

$host = 'localhost';
$dbName = 'globalstudios';
$user = 'root';
$passwd = '';

$db = new PDO('mysql:host=' . $host . ';dbname=' . $dbName, $user, $passwd);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 ?>
