<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Pyae Phyo Thant Shopping Project</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->

<?php
  $link = $_SERVER['PHP_SELF'];
  $linkExplode = explode('/',$link);
  $linkAddress = end($linkExplode);
  // print"<pre>";
  // print_r($linkExplode);
 ?>

 <?php
if($linkAddress !== 'order_list.php' && $linkAddress !== 'order_detail.php'&& $linkAddress !== 'weekly_report.php'&& $linkAddress !== 'monthly_report.php' && $linkAddress !== 'premium.php' && $linkAddress !== 'best_seller.php'){
?>
<form class="form-inline ml-3" method="post"
<?php if ($linkAddress == 'index.php'): ?>
 action="index.php"
<?php elseif ($linkAddress == 'category.php'):?>
 action="category.php"
<?php elseif($linkAddress == 'user_List.php'): ?>
action="user_List.php"
<?php endif; ?>
 >
 <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
  <div class="input-group input-group-sm">
    <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
      <button class="btn btn-navbar" type="submit">
        <i class="fas fa-search"></i>
      </button>
    </div>
  </div>
</form>

<?php } ?>



    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->

      <!-- Notifications Dropdown Menu -->


    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <span class="brand-text font-weight-light" style="text-align:center !important;">Admin Control Panels</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user8-128x128.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['user_name']?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <li class="nav-item">
            <a href="index.php" class="nav-link">
              &nbsp;&nbsp;<i class="fa fa-archive" aria-hidden="true"></i>&nbsp;
              <p>
                Products
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="category.php" class="nav-link">
              &nbsp;&nbsp;<i class="fa fa-list" aria-hidden="true"></i>&nbsp;
              <p>
                Categories
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="user_List.php" class="nav-link">&nbsp;
              <i class="fas fa-user"></i>
              <p>
               &nbsp;Accounts
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="order_list.php" class="nav-link">&nbsp;
              <i class="fas fa-question"></i>
              <p>
               &nbsp;Orders
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview menu ">
            <a href="#" class="nav-link " >
              <i class="fa fa-star"></i>
              <p>
                Sale Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weekly_report.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly Reporting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Reporting</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="premium.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Premium Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_seller.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Seller Items</p>
                </a>
              </li>
            </ul>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

    </div>
    <!-- /.content-header -->
