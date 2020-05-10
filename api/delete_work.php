<?php
header('Content-Type: application/json');
include('../db_connection.php');
// if(isset($_GET['id'])) {
//   echo json_encode($_GET['id']);
// } else {
//   echo json_encode('no id');
// }
if(isset($_GET['id'])) {
  $statement = $db->prepare('DELETE FROM works WHERE id = :id');
  $value = array('id' => $_GET['id']);
  $statement->execute($value);

  echo json_encode('{ id:' . $_GET['id'] . '}');
} else {
  echo json_encode('{ id: id not found }');
}

?>
