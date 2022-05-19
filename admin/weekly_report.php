
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
              <div  class="card-header">
                <h3  class="card-title">Weekly Reports</h3>
              </div>
              <!-- /.card-header -->
              <?php
              $today_date = date('Y-m-d');
              $start_date= date('Y-m-d',strtotime($today_date.'+1 day'));
              $end_date =  date('Y-m-d',strtotime($start_date.'-7 day'));
              // echo " $today_date $start_date  $end_date" ;
              $pdo_sale_order = $pdo->prepare("SELECT * FROM sale_order WHERE ordered_date<:s_date AND ordered_date>=:e_date");
              $pdo_sale_order->execute(
                array(
                  ':s_date'=>$start_date,
                  ':e_date'=>$end_date
                )
              );
              $result1 = $pdo_sale_order->fetchAll();
              // $userId = $result1['customer_id'];
              // $pdo_user = $pdo->prepare("SELECT * FROM users WHERE id=$userId");
              // $pdo_user->execute();
              // $result_user = $pdo_user->fetch(PDO::FETCH_ASSOC);
              // print"<pre>";
              // print_r($result1);
              // SELECT CUSTOMER //
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
                      <th>Customer Name</th>
                      <th>Total Price</th>
                      <th >Ordered Date (D-M-Y)</th>
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
                        <td><?php echo escape(date('d-m-Y',strtotime($value['ordered_date']))) ?></td>
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
