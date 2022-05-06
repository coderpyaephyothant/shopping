
<?php include('header.php') ?>
<?php
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>window.location.href='login.php'</script>";
}

if (!empty($_POST['search'])){
  setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
}else{
  if(empty($_GET['pagenumber'])){
    unset($_COOKIE['search']);
    setcookie('search', null, -1, '/');
  }
}
	require 'config/config.php';
if(!empty($_GET['pagenumber'])){
		$pagenumber = $_GET['pagenumber'];

} else {
	$pagenumber = 1;
}

$numberOfRecords = 3;
$offset = ($pagenumber - 1) * $numberOfRecords;

if(empty($_POST['search']) && empty($_COOKIE['search'])){
	//for select users from database-------
 $pdo_statement = $pdo->prepare( " SELECT * FROM products  ORDER BY id DESC " );
 $pdo_statement->execute();
 $raw_product_result = $pdo_statement->fetchAll();

	$totalpages = ceil( count($raw_product_result)/$numberOfRecords ) ;

	$pdo_stmt = $pdo->prepare("  SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
	$pdo_stmt->execute();
	$product_result= $pdo_stmt->fetchAll();
	// print"<pre>";
	// print_r($product_result);
} else {
	$searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
	$pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC  ");
	$pdo_stmt->execute();
	$raw_product_result = $pdo_stmt->fetchAll();
	$totalpages = ceil( count($raw_product_result)/$numberOfRecords ) ;

	$pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE name LIKE '%$searchKey%'  ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
	$pdo_stmt->execute();
	$product_result = $pdo_stmt->fetchAll();
}
?>
<div class="container">
	<div class="row">
		<div class="col-xl-3 col-lg-4 col-md-5">
			<div class="sidebar-categories">
				<div class="head"> <a href="index.php" style="color:#fff !important;">Browse Categories</a> </div>
				<ul class="main-categories">
					<li class="main-nav-list">
						<?php
							$pdo_categories = $pdo->prepare(" SELECT * FROM categories ORDER BY id DESC ");
							$pdo_categories->execute();
							$catefories_result = $pdo_categories->fetchAll();
							// print"<pre>";
							// print_r($catefories_result);exit();
							if ($catefories_result){
								foreach ($catefories_result as  $value) {?>
									<a data-toggle="collapse"
										href="#">
										<span class="lnr lnr-arrow-right"></span>
										<?php echo escape($value['name']) ?></a>
							<?php
						}
							}
						 ?>
					</li>
				</ul>
			</div>
			</div>
		<div class="col-xl-9 col-lg-8 col-md-7">

<div class="filter-bar d-flex flex-wrap align-items-center">
	<div class="pagination">
		<a href="?pagenumber=1" class="active">First</a>
		<a <?php if($pagenumber <=1){ echo 'disabled'; } ?>
			 href="<?php if($pagenumber <=1){ echo '#';}else{ echo "?pagenumber=".($pagenumber-1);} ?>" class="prev-arrow">
			 <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
		 </a>
		<a href="#" class="active"><?php echo $pagenumber; ?></a>
		<a <?php if($pagenumber >= $totalpages){ echo 'disabled';} ?>
			href="<?php if ($pagenumber >=$totalpages){ echo '#'; }else{ echo "?pagenumber=".($pagenumber+1);} ?>" class="next-arrow">
			<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
		</a>
		<a href="?pagenumber=<?php echo $totalpages ?>" class="active">Last</a>
	</div>
</div>



				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">

						<?php
							if ($product_result){
								foreach ($product_result as  $value) {?>

									<div class="col-lg-4 col-md-6">
										<div class="single-product">
											<img class="img-fluid" src="admin/images/<?php echo escape($value['image']) ?>" alt="" style="width:250px; height:300px";>
											<div class="product-details">
												<h6><?php echo escape($value['name']) ?></h6>
												<div class="price">
													<h6><?php echo escape($value['price'].'MMK') ?></h6>
												</div>
												<div class="prd-bottom">

													<a href="" class="social-info">
														<span class="ti-bag"></span>
														<p class="hover-text">add to bag</p>
													</a>
													<a href="" class="social-info">
														<span class="lnr lnr-move"></span>
														<p class="hover-text">view more</p>
													</a>
												</div>
											</div>
										</div>
									</div>

									<?php
								}
							}
						 ?>
						<!-- single product -->


					</div>
				</section>
				<!-- End Best Seller -->
<?php include('footer.php');?>
