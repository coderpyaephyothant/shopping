
<?php
session_start();
require 'config/config.php';
require 'config/common.php';
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>window.location.href='login.php'</script>";
}

if($_SESSION['role'] != 1 ){
  echo "<script>alert('Must be Admin Account..');window.location.href='login.php'</script>";
}


 ?>
 <?php
 include('header.php');
  ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div  class="card-header">
                <h3  class="card-title">Best Seller Items - <b> Above 5 items</b>  </h3>
              </div>
              <!-- /.card-header -->
              <?php
              // $pdo_sale_order = $pdo->prepare("SELECT * FROM sale_order_details GROUP BY product_id HAVING SUM(quantity)>3");
              $pdo_total_qty = $pdo->prepare("SELECT product_id, SUM(quantity) total FROM sale_order_details GROUP BY product_id;");
              $pdo_total_qty->execute();
              $result1 = $pdo_total_qty->fetchAll();

              // print"<pre>";
              // print_r($result1);exit(); // sale_order result
              // print_r($result_user['name']); // name result
               ?>
              <div class="card-body">
                <a href="product_create.php" class="btn btn-primary" style="background:#36cb75 !important;border:0px !important;">Create Product</a> <br> <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th >#</th>
                      <th>Product Name</th>
                      <th>Price</th>
                      <th >Numbers</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  if ($result1){
                    $i = 1;
                    foreach ($result1 as  $value) {
                      if ($value['total']>5){
                        $product_id = $value['product_id'];
                        $pdo_user = $pdo->prepare("SELECT * FROM products WHERE id=$product_id");
                        $pdo_user->execute();
                        $result_product = $pdo_user->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <tr>
                          <td><?php echo escape($i) ?></td>
                          <td><?php echo escape($result_product['name']) ?></td>
                          <td><?php echo escape($result_product['price']) ?></td>
                          <td><?php echo escape($value['total']) ?></td>
                        </tr>
                    <?php
                    $i ++;
                  }
                      }

                  }

                   ?>
                  </tbody>
                </table> <br>

              </div>

              <!-- /.card-body -->







            </div>
            <!-- /.card -->
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
  <?php
  include('footer.html');
   ?>
