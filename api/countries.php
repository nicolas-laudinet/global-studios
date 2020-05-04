<?php

header('Content-Type: application/json');

include('../db_connection.php');

$countries = fetchData($db, 'country');

$JSON = json_encode($countries, JSON_PRETTY_PRINT);

print_r($JSON);

function fetchData($db, $table, $id = null, $idKey = 'id') {

  if($id) {
    $SQL_Query = "SELECT * FROM " . $table . " WHERE " . $table . "." . $idKey . " = :id";
    $statement = $db->prepare($SQL_Query);
    $statement->bindValue(':id', $id);

  } else {
    $SQL_Query = "SELECT * FROM " . $table;
    $statement = $db->prepare($SQL_Query);

  }

  $statement->execute();

  return $statement->fetchAll(PDO::FETCH_ASSOC);

}

 ?>
