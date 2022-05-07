<?php include('header.php');
require 'config/config.php';


if(!empty($_GET['id'])){
  $id = $_GET['id'];
  $pdo_product_detail = $pdo->prepare(" SELECT * FROM products WHERE id=$id ");
  $pdo_product_detail->execute();
  $product_detail_result = $pdo_product_detail->fetch(PDO::FETCH_ASSOC);
  // print"<pre>";
  // print_r($product_detail_result);

}




 ?>
<!--================Single Product Area =================-->
<div class="product_image_area">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">

          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo escape($product_detail_result['image']) ?>" alt="">
          </div>

      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo escape($product_detail_result['name']) ?></h3>
          <h2><?php echo escape($product_detail_result['price'].' MMK') ?></h2>
          <?php
          $cat_id = $product_detail_result['category_id'];
          $pdo_categories = $pdo->prepare(" SELECT * FROM categories WHERE id=$cat_id ");
          $pdo_categories->execute();
          $result_categories = $pdo_categories->fetch(PDO::FETCH_ASSOC);
          // print"<pre>";
          // print_r($result_categories);
           ?>
          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : <?php echo escape($result_categories['name']) ?></a></li>
            <li><a href="#"><span>Availibility</span> : In Stock</a></li>
          </ul>
          <p><?php echo escape($product_detail_result['description']) ?></p>
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
             class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
             class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <a class="primary-btn" href="#">Add to Cart</a>
            <a class="primary-btn" href="index.php">Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
