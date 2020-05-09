<?php
$connectionState = '';

if(!empty($_POST['username']) && !empty($_POST['password'])) {
  $connectionState = authenticate_user($_POST['username'], $_POST['password']);
  if($connectionState === 'CONNECTED') {
    session_start();
    $_SESSION['connected'] = true;
    $_SESSION['user'] = $_POST['username'];
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/backoffice/home.php');
  }
} else {
  $connectionState = 'NO_CREDITS';
}

function authenticate_user($inputUsername, $inputPassword) {
  include('../db_connection.php');

  $statement = $db->prepare('SELECT password FROM user WHERE name = :username');
  $value = array('username' => $inputUsername);
  $userExists = $statement->execute($value);
  if(!$userExists) return 'NO_USER';

  $response = $statement->fetch(PDO::FETCH_ASSOC);

  if($response['password'] === md5($inputPassword . 'secret')) {
    return 'CONNECTED';
  } else {
    return 'WRONG_PASS';
  }
}

?>

<!DOCTYPE html>
<html>

<?php

$pageTitle = "Global Studios Backoffice";
include('bo_head.php');

?>

  <body>
    <div class="container">
      <!-- <div class="row"> -->
        <h2>Back office connection</h2>
        <form method="post">
          <label for="username">Username : </label>
          <input type="text" name="username" id="username">
          <p style="color:red"><?= $connectionState == 'NO_USER' ? 'Username not found' : ''?></p>
          <br>
          <label for="password">Password : </label>
          <input type="password" name="password" id="password">
          <p style="color:red"><?= $connectionState == 'WRONG_PASS' ? 'Wrong password' : ''?></p>

          <input type="submit" name="" value="Submit">
          <p style="color:red"><?= $connectionState == 'NO_CREDITS' ? 'Enter username and password' : ''?></p>

        </form>
      <!-- </div> -->
    </div>

  </body>
</html>
