<?php

include('../db_connection.php');

$SQL_Query = "SELECT * FROM messages";
$statement = $db->prepare($SQL_Query);
$statement->execute();
$messages = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html>
<?php $pageTitle = 'Add Studio' ?>
<?php include('bo_head.php') ?>

<body>

  <div class="container">

    <?php include('./bo_menu.php'); ?>

    <form class="select-message" method="GET">
      <select name="message-id">
        <?php foreach($messages as $message) { ?>
          <option value="<?= $message['id'] ?>"><?= $message['date'], ' : ', $message['author'] ?></option>
        <?php } ?>
      </select>
      <input type="submit" value="Selectionner le message">
    </form>

    <?php if(isset($_GET['message-id'])) { ?>
      <?php foreach($messages as $message) {
        if($message['id'] === $_GET['message-id']) {
          $currentMessage = $message;
        }
      } ?>


      <h2>Author : <?= $currentMessage['author'] ?></h2>
      <h3>Sent at : <?= $currentMessage['date'] ?></h3>
      <h3>Message : </h3>
      <p><?= $currentMessage['body'] ?></p>
    <?php } ?>

  </div><!-- .container -->


</body>
</html>
