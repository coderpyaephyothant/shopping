
<?php
 include('header.php') ?>
<?php
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>window.location.href='login.php'</script>";
}
// print"<pre>";
// print_r($_SESSION) ;
if (!empty($_POST['search']) ){
  setcookie('search', $_POST['search'] , time() + (86400 * 30), "/");
  // 86400 = 1 day
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

if(empty($_POST['search']) && empty($_COOKIE['search']) ){

  if (!empty($_GET['id'])){
    $id = $_GET['id'];
    // $pdo_products_by_id = $pdo->prepare(" SELECT * FROM products WHERE category_id=".$_GET['id']);
    // $pdo_products_by_id->execute();
    // $pdo_result = $pdo_products_by_id->fetchAll();
    // print"<pre>";
    // print_r($pdo_result);exit();
    $pdo_statement = $pdo->prepare( " SELECT * FROM products WHERE category_id=$id ORDER BY id DESC " );
    $pdo_statement->execute();
    $raw_product_result = $pdo_statement->fetchAll();
    // print"<pre>";
    // print_r($raw_product_result);exit();

   	$totalpages = ceil( count($raw_product_result)/$numberOfRecords ) ;

   	$pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE category_id=$id ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
   	$pdo_stmt->execute();
   	$product_result= $pdo_stmt->fetchAll();
  }else{
    $pdo_statement = $pdo->prepare( " SELECT * FROM products  ORDER BY id DESC " );
    $pdo_statement->execute();
    $raw_product_result = $pdo_statement->fetchAll();


   	$totalpages = ceil( count($raw_product_result)/$numberOfRecords ) ;

   	$pdo_stmt = $pdo->prepare("  SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
   	$pdo_stmt->execute();
   	$product_result= $pdo_stmt->fetchAll();
  }
} else {
	$searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
	$pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC  ");
	$pdo_stmt->execute();
	$raw_product_result = $pdo_stmt->fetchAll();
  // print"<pre>";
  // print_r($raw_product_result);exit();
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
							// print_r($catefories_result);
              // $number_products = 0;
							if ($catefories_result){
								foreach ($catefories_result as  $value) {
                  // print"<pre>";
                  // print_r($product_cat_result);
                  // echo $product_cat_result['name'];
                  $product_id = $value['id'];
                  $pdo_products_cat = $pdo->prepare(" SELECT * FROM products WHERE category_id=$product_id ");
                  $pdo_products_cat->execute();
                  $product_cat_result = $pdo_products_cat->fetchAll();
                  // print"<pre>";
                  // print_r($product_cat_result);
                  if ($product_cat_result){
                    ?>
                      <a href="index.php?id=<?php echo $value['id'] ?>"><?php echo escape($value['name']) ?><span style="color:green; opacity:0.7;"> &nbsp; (<?php echo   count($product_cat_result); ?>)</span> </a>
                    <!-- // print"<pre>";
                    // print_r($product_cat_result[0]['quantity']); -->
                    <?php
                    // $number_products ++;
                  }
                  ?>
<!-- <br> <br> -->
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
                      <a href="product_detail.php?id=<?php echo $value['id'] ?>">
											<img class="img-fluid" src="admin/images/<?php echo escape($value['image']) ?>" alt="" style="width:250px; height:350px";>
                      </a>
                      <div class="product-details">
												<h6><?php echo escape($value['name']) ?></h6>
												<div class="price">
													<h6><?php echo escape($value['price'].'MMK') ?></h6>
												</div>
												<div class="prd-bottom">
													<a href="product_detail.php?id=<?php echo $value['id'] ?>" class="social-info">
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
