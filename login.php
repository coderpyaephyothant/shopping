

<?php
session_start();
require 'config/common.php';
require 'config/config.php';


	if (!empty($_POST)) {
		$email = $_POST['email'];
		$password = $_POST['password'];
		echo $email;
		if (empty($_POST['email']) || empty($_POST['password'])){
			if (empty($_POST['email'])){
				$emailError = ' Registered email is Required. . . ';
			}
			if (empty($_POST['password'])){
				$passwordError = ' Please Insert your password. . . ';
			}
		}else {
			echo "selecting. . . .";
			$pdo_email_check = $pdo->prepare(" SELECT * FROM users WHERE email=:email  ");
			$pdo_email_check->execute(
				array(
					':email'=> $email
				)
			);
			$email_checked_result = $pdo_email_check->fetch(PDO::FETCH_ASSOC);
			// print"<pre>";
			// print_r($email_checked_result);exit();
			if ($email_checked_result){
				if (password_verify($password,$email_checked_result['password'])){
					$_SESSION['user_name'] = $email_checked_result['name'];
					$_SESSION['role'] = $email_checked_result['role'];
					$_SESSION['logged_in'] = time();
					header('Location:index.php');
				}
			}else{
				echo"<script>alert('Incorrect Credentials. . . .');</script>";
			}
		}
	}

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
	<title>Pyae Phyo Thant Shopping Project</title>

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
					<a class="navbar-brand logo_h" href="index.html" style="padding-bottom:0rem !important;"><h4>Pyae Phyo Thant's Shopping Project<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->

				</div>
			</nav>
		</div>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Login/Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="login_form_inner" style="padding-top: 20px !important;padding-bottom: 20px !important;">
						<h3 style="text-transform:none !important;">Login Form </h3>


						<!-- form start -->
						<form class="row login_form" action="login.php" method="POST" id="contactForm" novalidate="novalidate">
							<input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
							<div class="col-md-12 form-group">
								<p  style="float:left !important; color:red;"><?php echo empty($emailError) ? '' : $emailError ?></p>
								<input type="text" style="<?php echo empty($emailError) ? '' : 'border: 1px solid red' ; ?>" class="form-control" id="name" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							</div>
							<div class="col-md-12 form-group">
								<p  style="float:left !important; color:red;"><?php echo empty($passwordError) ? '' : $passwordError ?></p>
								<input type="password" style="<?php echo empty($passwordError) ? '' : 'border: 1px solid red' ; ?>"  class="form-control" id="name" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Log In</button>
							</div>
						</form>
						<!-- form End -->



					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->

	<!-- start footer Area -->
	<footer class="footer-area section_gap">
	<div class="container">
	<div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
	  <p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
	Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved.
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
