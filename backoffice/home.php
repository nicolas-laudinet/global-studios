
<!DOCTYPE html>
<html>

<?php

$pageTitle = "Global Studios Backoffice";
include('bo_head.php');

 ?>

<?php
session_start();
if(isset($_SESSION['connected']) && $_SESSION['connected']) { ?>


 <body>
   <h2>Welcome <?= $_SESSION['user'] ?></h2>
   <?php include('bo_menu.php'); ?>
 </body>
</html>

<?php } else { ?>

<h2>Connection Refused</h2>

<?php } ?>
