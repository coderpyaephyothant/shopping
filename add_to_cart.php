<?php
session_start();
require 'config/config.php';
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>window.location.href='login.php'</script>";
}

if (!empty($_POST)){
  $id = $_POST['id'];
  $quantity = $_POST['qty']; //counter....
  $pdo_quantity = $pdo->prepare(" SELECT * FROM products WHERE id=$id ");
  $pdo_quantity->execute();
  $quantity_result = $pdo_quantity->fetch(PDO::FETCH_ASSOC);
  // print"<pre>";
  // print_r($quantity_result);
  if ($quantity > $quantity_result['quantity']){
    // echo "string";
    echo"<script>alert('Your order-amount is Not Avaliable right now...');window.location.href='product_detail.php?id=$id';</script>";
  }else{

    if (isset($_SESSION['cart']['id'.$id])){
      $_SESSION['cart']['id'.$id] += $quantity;
    }else{
      $_SESSION['cart']['id'.$id] = $quantity;
    }
    header('Location:cart.php');

  }
}
 ?>
