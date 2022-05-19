

<?php

session_start();
require 'config/config.php';
require 'config/common.php';
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>window.location.href='login.php'</script>";
}

$user_id = $_SESSION['user_id'];
$total_price =0;
	if (!empty($_SESSION['cart'])){
		// sessionCart foreact Loop -----
		foreach ($_SESSION['cart'] as $key => $quantity) {

			$keyId = str_replace('id','',$key);
			$pdo_cart_products = $pdo->prepare(" SELECT * FROM products WHERE id=$keyId ");
			$pdo_cart_products->execute();
			$result_session_products = $pdo_cart_products->fetch(PDO::FETCH_ASSOC);
			// print"<pre>";
		  // print_r($result_session_products);
			$total_each = $result_session_products['price'] * $quantity;
			// echo $total_each;
			$total_price += $total_each;
			// echo $total_price;
		}

		// add to sale order table & sale order_details mysql_list_tables

		// add to sale_order_table...
		$pdo_add_sale_order_table = $pdo->prepare(" INSERT INTO sale_order (customer_id,total_price,ordered_date) VALUES (:cid,:tp,:od) ");
		$result_add_sale_order_table = $pdo_add_sale_order_table -> execute(
			array (
				':cid' => $user_id,
				':tp' => $total_price,
				':od'=> date('Y-m-d H:i:s')
			)
		);
				if ($result_add_sale_order_table ) {
					$s_o_d =$pdo->LastInsertId();

					foreach ($_SESSION['cart'] as $key => $quantity) {
						$keyId = str_replace('id','',$key);
						$pdo_add_sale_details_table = $pdo->prepare(" INSERT INTO sale_order_details (sale_order_id,product_id,quantity) VALUES (:sod,:pid,:qty) ");
						$result_add_sale_details_table = $pdo_add_sale_details_table->execute(
							array(
								':sod' => $s_o_d,
								':pid' => $keyId,
								':qty' => $quantity
							)
						);

						//product and its quantity database // update
						$pdo_product_database_quantity = $pdo->prepare(" SELECT * FROM products WHERE id=$keyId ");
						$pdo_product_database_quantity->execute();
						$pdo_result_database_quantity = $pdo_product_database_quantity->fetch(PDO::FETCH_ASSOC);

						$real_quantity_data = $pdo_result_database_quantity['quantity'] - $quantity;

						$pdo_finish_quantity = $pdo->prepare(" UPDATE products SET quantity=:qty WHERE id=$keyId  ");
						$result_finished = $pdo_finish_quantity->execute(
							array(
								':qty' => $real_quantity_data
							)
						);

						unset($_SESSION['cart']);
					}

			// add to sale _order_details table----


		}

};

?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Favicon-->
	<link rel="shortcut icon" href="img/fav.png">
	<!-- Author Meta -->
	<meta name="author" content="CodePixar">
	<!-- Meta Description -->
	<meta name="description" content="">
	<!-- Meta Keyword -->
	<meta name="keywords" content="">
	<!-- meta character set -->
	<meta charset="UTF-8">
	<!-- Site Title -->
	<title>Piae Thant Shop</title>

	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><h4>AP Shopping<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><a href="#" class="cart"><span class="ti-bag"></span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Confirmation</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Order Details Area =================-->
	<section class="order_details section_gap">
		<div class="container">
			<h3 class="title_confirmation">Thank you. Your orders has been received.</h3>
			<div class="row order_d_inner">
				<div class="col-lg-12">
					<div class="details_item">
						<h4>Order Info</h4>
						<ul class="list">
							<li><a href="#"><span>Order number</span> : 60235</a></li>
							<li><a href="#"><span>Date</span> : Los Angeles</a></li>
							<li><a href="#"><span>Total</span> : USD 2210</a></li>
							<li><a href="#"><span>Payment method</span> : Check payments</a></li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</section>
	<!--================End Order Details Area =================-->

	<!-- start footer Area -->
	<footer class="footer-area section_gap">
		<div class="container">
			<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
				<p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
</p>
			</div>
		</div>
	</footer>
	<!-- End footer Area -->




	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>
