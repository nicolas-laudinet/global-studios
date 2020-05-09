<?php

header('Content-Type: application/json');

include('../db_connection.php');
include('../backoffice/db_functions.php');

if($_POST) {
  if($_POST['name'] && $_POST['mail'] && $_POST['body']) {
    $return = [];

    if(recordMessage($_POST, $db)) {
      $return['success'] = true;
      $return['message'] = 'Hello ' . $_POST['name'] . ', your message was received !';

    } else {
      $return['success'] = false;
      $return['message'] = 'Sorry ' . $_POST['name'] . ', an error occured :(';
    }

  } else {
    $return['success'] = false;
    $return['message'] = 'Sorry ' . $_POST['name'] . ', an error occured :(';
  }

} else {
  $return['success'] = false;
  $return['message'] = 'Sorry, an error occured :(';
}

echo json_encode($return);

?>
