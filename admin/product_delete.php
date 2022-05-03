<?php require 'config/config.php';

  $pdo_delete = $pdo->prepare(" DELETE FROM products WHERE id=".$_GET['id']);
  $delete_result= $pdo_delete->execute();
  if ($delete_result){
    echo "<script>alert('Successfully Deleted');window.location.href='index.php';</script>";
  }
 ?>
