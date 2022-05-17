<?php
session_start();
unset($_SESSION['cart']['id'.$_GET['cat_id']]);
header('Location:cart.php');
 ?>
