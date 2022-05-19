
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

if (!empty($_GET['sale_order_id'])){
  setcookie('sale_order_id', $_GET['sale_order_id'], time() + (86400 * 30), "/"); // 86400 = 1 day
}else{
  if(empty($_GET['pagenumber'])){
    unset($_COOKIE['sale_order_id']);
    setcookie('sale_order_id', null, -1, '/');
  }
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
              <div class="card-header">
                <div class="btn-group" style="float:right !important;">
                  <div class="container">
                    <a href="order_list.php" class="btn btn-primary">  < Back  </a>
                  </div>
                </div>
                <h3 class="card-title">Order Details</h3>

              </div>
              <!-- /.card-header -->
              <?php

              if(!empty($_GET['pagenumber'])){
                  $pagenumber = $_GET['pagenumber'];

              } else {
                $pagenumber = 1;
              }

              $numberOfRecords = 3;
              $offset = ($pagenumber - 1) * $numberOfRecords;

              // i solved pagination problem within 10 minutes.....haha..easy!
              if (!empty($_GET['sale_order_id'])){
                $sale_id = $_GET['sale_order_id'];
                // echo $sale_id;
                //for select users from database-------
               $pdo_statement = $pdo->prepare( " SELECT * FROM sale_order_details  WHERE sale_order_id=$sale_id");
               $pdo_statement->execute();
               $raw_ordered_details_result = $pdo_statement->fetchAll();
               // print"<pre>";
               // print_r($raw_ordered_details_result);exit();

                $totalpages = ceil( count($raw_ordered_details_result)/$numberOfRecords ) ;

                $pdo_stmt = $pdo->prepare("  SELECT * FROM sale_order_details WHERE sale_order_id=$sale_id  LIMIT  $offset,$numberOfRecords "  );
                $pdo_stmt->execute();
                $ordered_details_result= $pdo_stmt->fetchAll();
              }else{
                $s_key = !empty($_GET['sale_order_id']) ? $_GET['sale_order_id'] : $_COOKIE['sale_order_id'];
                $pdo_statement = $pdo->prepare( " SELECT * FROM sale_order_details  WHERE sale_order_id LIKE '%$s_key%' ORDER BY id DESC ");
                $pdo_statement->execute();
                $raw_ordered_details_result = $pdo_statement->fetchAll();
                // print"<pre>";
                // print_r($raw_ordered_details_result);exit();

                 $totalpages = ceil( count($raw_ordered_details_result)/$numberOfRecords ) ;

                 $pdo_stmt = $pdo->prepare("  SELECT * FROM sale_order_details WHERE sale_order_id LIKE '%$s_key%' ORDER BY id DESC LIMIT  $offset,$numberOfRecords "  );
                 $pdo_stmt->execute();
                 $ordered_details_result= $pdo_stmt->fetchAll();
              }
                // print"<pre>";
                // print_r($ordered_details_result);exit();

              ?>

              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th >#</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Order Date : (date.month.year)</th>
                      <th>Image</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (!empty($ordered_details_result)){
                      $id=1;
                      foreach ($ordered_details_result as $value) { ?>
                        <?php
                        $pdo_cat_name = $pdo->prepare("SELECT * FROM products   WHERE id=".$value['product_id'] );
                        $pdo_cat_name->execute();
                        $name_result = $pdo_cat_name->fetchAll();
                        // print"<pre>";
                        // print_r($name_result);exit();

                      ?>
                      <tr>
                        <td> <?php echo $id ?></td>
                        <td><?php echo $name_result[0]['name'] ?></td>
                        <td><?php echo $value['quantity'] ?></td>
                        <td>
                          <?php echo $name_result[0]['price'] ?></td>
                        <td><?php  echo date("d-m-Y", strtotime($value['ordered_date']) );?></td>
                        <td style="text-align: center;">
                          <img src="images/<?php echo $name_result[0]['image'] ?>" alt="" width="80">
                        </td>

                      </tr>
                      <?php
                      $id ++;
                      }
                      }
                       ?>
                  </tbody>
                </table> <br>
                <nav aria-label="Page navigation example" style="float:right">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pagenumber=1">First</a></li>
                    <li class="page-item <?php if($pagenumber <=1){ echo 'disabled'; } ?>">
                      <a class="page-link" href="<?php if($pagenumber <=1){ echo '#';}else{ echo "?pagenumber=".($pagenumber-1);} ?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pagenumber; ?></a></li>
                    <li class="page-item <?php if($pagenumber >= $totalpages){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if ($pagenumber >=$totalpages){ echo '#'; }else{ echo "?pagenumber=".($pagenumber+1);} ?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pagenumber=<?php echo $totalpages ?>">Last</a></li>
                  </ul>
                </nav>
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
