
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

if (!empty($_POST['search'])){
  setcookie('search', $_POST['search'], time() + (86400 * 30), "/"); // 86400 = 1 day
}else{
  if(empty($_GET['pagenumber'])){
    unset($_COOKIE['search']);
    setcookie('search', null, -1, '/');
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
                <h3 class="card-title">Order Lists</h3>
              </div>
              <!-- /.card-header -->
              <?php

              if(!empty($_GET['pagenumber'])){
                  $pagenumber = $_GET['pagenumber'];

              } else {
                $pagenumber = 1;
              }

              $numberOfRecords = 2;
              $offset = ($pagenumber - 1) * $numberOfRecords;


                //for select users from database-------
               $pdo_statement = $pdo->prepare( " SELECT * FROM sale_order  ORDER BY id DESC " );
               $pdo_statement->execute();
               $raw_ordered_result = $pdo_statement->fetchAll();

                $totalpages = ceil( count($raw_ordered_result)/$numberOfRecords ) ;

                $pdo_stmt = $pdo->prepare("  SELECT * FROM sale_order ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
                $pdo_stmt->execute();
                $ordered_result= $pdo_stmt->fetchAll();
                // print"<pre>";
                // print_r($user_result);exit();

              ?>

              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th >#</th>
                      <th>Customers' Name</th>
                      <th>Total Price</th>
                      <th>Ordered Date : (D-M-Y)</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (!empty($ordered_result)){
                      $id=1;
                      foreach ($ordered_result as $value) { ?>
                        <?php
                        $pdo_cat_name = $pdo->prepare("SELECT * FROM users   WHERE id=".$value['customer_id'] );
                        $pdo_cat_name->execute();
                        $name_result = $pdo_cat_name->fetchAll();
                        // print"<pre>";
                        // print_r($name_result);exit();

                      ?>
                      <tr>
                        <td> <?php echo $id ?></td>
                        <td><?php echo $name_result[0]['name'] ?></td>
                        <td><?php echo $value['total_price'] ?></td>
                        <td><?php  echo date("d-m-Y", strtotime($value['ordered_date']) );?></td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="order_detail.php?sale_order_id=<?php echo $value['id'] ?>" class="btn btn-primary">  > Details  </a>
                            </div>
                          </div>
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
