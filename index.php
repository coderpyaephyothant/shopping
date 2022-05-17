
<?php
 include('header.php');
 // require 'config/config.php';
  ?>
<?php
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>window.location.href='login.php'</script>";
}
// print"<pre>";
// print_r($_SESSION) ;

//for search cookie
if (!empty($_POST['search']) ){
  setcookie('search', $_POST['search'] , time() + (86400 * 30), "/");
  // 86400 = 1 day
}else{
  if(empty($_GET['pagenumber'])){
    unset($_COOKIE['search']);
    setcookie('search', null, -1, '/');
  }
}
//for select cat cookie
if (!empty($_GET['id']) ){
  setcookie('id', $_GET['id'] , time() + (86400 * 30), "/");
  // 86400 = 1 day
}else{
  if(empty($_GET['pagenumber'])){
    unset($_COOKIE['id']);
    setcookie('id', null, -1, '/');
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

  if (!empty($_GET['id'])  || !empty($_COOKIE['id'])){

    $selectKey = !empty($_GET['id']) ? $_GET['id'] : $_COOKIE['id'];

    $pdo_statement = $pdo->prepare( " SELECT * FROM products WHERE category_id LIKE '%$selectKey%' AND quantity >0  ORDER BY id DESC " );
    $pdo_statement->execute();
    $raw_product_result = $pdo_statement->fetchAll();

   	$totalpages = ceil( count($raw_product_result)/$numberOfRecords ) ;

   	$pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE category_id LIKE '%$selectKey%' AND quantity >0   ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
   	$pdo_stmt->execute();
   	$product_result= $pdo_stmt->fetchAll();
    // print"<pre>";
    // print_r($raw_product_result);
  }else{
    $pdo_statement = $pdo->prepare( " SELECT * FROM products WHERE quantity >0   ORDER BY id DESC " );
    $pdo_statement->execute();
    $raw_product_result = $pdo_statement->fetchAll();

   	$totalpages = ceil( count($raw_product_result)/$numberOfRecords ) ;

   	$pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE quantity >0 ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
   	$pdo_stmt->execute();
   	$product_result= $pdo_stmt->fetchAll();
  }
} else {
	$searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
	$pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity >0  ORDER BY id DESC  ");
	$pdo_stmt->execute();
	$raw_product_result = $pdo_stmt->fetchAll();
  // print"<pre>";
  // print_r($raw_product_result);exit();
	$totalpages = ceil( count($raw_product_result)/$numberOfRecords ) ;

	$pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity >0 ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
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


              // $number_products = 0;
							if ($catefories_result){

								foreach ($catefories_result as  $value) {

                  $cat_number =$value['id'];
                  $pdo_category_number = $pdo->prepare(" SELECT * FROM products WHERE category_id=$cat_number ");
                  $pdo_category_number->execute();
                  $pdo_number_result=$pdo_category_number->fetchAll();
                  // print"<pre>";
    							// print_r($pdo_number_result);

                  ?>


                  <a href="index.php?id=<?php echo $value['id'] ?>"><?php echo escape($value['name']) ?><span style="color:green; opacity:0.7;"> &nbsp;[&nbsp;<?php echo count($pdo_number_result); ?>&nbsp;]</a>

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
											<img class="img-fluid" src="admin/images/<?php echo escape($value['image']) ?>" alt="" style="width:100px; height:150px;";>
                      </a>
                      <div class="product-details">
                        <b><p><?php echo escape($value['name']) ?></p></b>
												<div class="price">
													<p><?php echo escape($value['price'].'MMK') ?></p>
												</div>
												<div class="prd-bottom">
                          <form class="" action="add_to_cart.php" method="post">
                            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                            <input type="hidden" name="id" value="<?php echo escape($value['id']); ?>">
                            <input type="hidden" name="qty" value="1">
                            <div href="#" class="social-info"  >
                              <button type="submit" name="button" style="border:0px !important; background:none;">
                                <span style="right:5px;" class="ti-bag"></span>
                                <p class="hover-text" style="left:25px !important;">Add to Cart</p></button>
                            </div>

  													<a  href="product_detail.php?id=<?php echo $value['id'] ?>" class="social-info">
  														<span class="lnr lnr-move"></span>
  														<p class="hover-text">view more</p>
  													</a>
                          </form>
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
