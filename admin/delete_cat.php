<?php

session_start();
require 'config/config.php';

$pdo_statement = $pdo->prepare(" DELETE FROM categories WHERE id=".$_GET['id']);
$deleteResult = $pdo_statement->execute();
if ($deleteResult){
  echo "<script>alert('Successfully deleted...');window.location.href='category.php';</script>";
}

 ?>
