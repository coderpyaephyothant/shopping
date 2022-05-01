<?php
session_start();
require 'config/config.php';

$pdo_user_delete = $pdo->prepare(" DELETE FROM users WHERE id= ".$_GET['id']);
$user_detail_deleted = $pdo_user_delete->execute();
if ($user_detail_deleted){
  echo " <script>alert('User Account Has Been Deleted. . . ');window.location.href='user_List.php';</script> ";
}
 ?>
