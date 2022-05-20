
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
                <h3  class="card-title">Premium Customers - Above 500k</h3>
              </div>
              <!-- /.card-header -->
              <?php
              $premium_price = 500000;
              $pdo_sale_order = $pdo->prepare("SELECT * FROM sale_order WHERE total_price >= :t_price ORDER BY id");
              $pdo_sale_order->execute(
                array(
                  ':t_price'=>$premium_price
                )
              );
              $result1 = $pdo_sale_order->fetchAll();

              // print"<pre>";
              // print_r($result1); // sale_order result
              // print_r($result_user['name']); // name result
               ?>
              <div class="card-body">
                <a href="product_create.php" class="btn btn-primary" style="background:#36cb75 !important;border:0px !important;">Create Product</a> <br> <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th >#</th>
                      <th>Premium Customer Name</th>
                      <th>Total Price</th>
                      <th >Ordered Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  if ($result1){
                    $i = 1;
                    foreach ($result1 as  $value) {
                      $userId = $value['customer_id'];
                      $pdo_user = $pdo->prepare("SELECT * FROM users WHERE id=$userId");
                      $pdo_user->execute();
                      $result_user = $pdo_user->fetch(PDO::FETCH_ASSOC);
                      ?>
                      <tr>
                        <td><?php echo escape($i) ?></td>
                        <td><?php echo escape($result_user['name']) ?></td>
                        <td><?php echo escape($value['total_price']) ?></td>
                        <td><?php echo escape(date('Y-m-d',strtotime($value['ordered_date']))) ?></td>
                      </tr>
                  <?php
                  $i ++;
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
