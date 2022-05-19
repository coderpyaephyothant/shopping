
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
                <h3 class="card-title">Product Lists</h3>
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

              if(empty($_POST['search']) && empty($_COOKIE['search'])){
                //for select users from database-------
               $pdo_statement = $pdo->prepare( " SELECT * FROM products  ORDER BY id DESC " );
               $pdo_statement->execute();
               $raw_user_result = $pdo_statement->fetchAll();

                $totalpages = ceil( count($raw_user_result)/$numberOfRecords ) ;

                $pdo_stmt = $pdo->prepare("  SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
                $pdo_stmt->execute();
                $product_result= $pdo_stmt->fetchAll();
                // print"<pre>";
                // print_r($product_result);
              } else {
                $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
                $pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC  ");
                $pdo_stmt->execute();
                $result2 = $pdo_stmt->fetchAll();
                $totalpages = ceil( count($result2)/$numberOfRecords ) ;

                $pdo_stmt = $pdo->prepare("  SELECT * FROM products WHERE name LIKE '%$searchKey%'  ORDER BY id DESC LIMIT $offset,$numberOfRecords  ");
                $pdo_stmt->execute();
                $product_result = $pdo_stmt->fetchAll();


              }
              ?>

              <div class="card-body">
                <a href="product_create.php" class="btn btn-primary" style="background:#36cb75 !important;border:0px !important;">Create Product</a> <br> <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th >#</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th >Category</th>
                      <th>In Stock</th>
                      <th>Price</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (!empty($product_result)){
                      $id=1;
                      foreach ($product_result as $value) { ?>
                        <?php
                        $pdo_cat_name = $pdo->prepare("SELECT * FROM categories  WHERE id=".$value['category_id'] );
                        $pdo_cat_name->execute();
                        $name_result = $pdo_cat_name->fetchAll();
                        // print"<pre>";
                        // print_r($name_result);exit();

                      ?>
                      <tr>
                        <td> <?php echo $id ?></td>
                        <td><?php echo escape($value  ['name']) ?></td>
                        <td>
                          <?php echo escape(substr($value ['description'],0,30).'. . . .')?>
                        </td>
                        <td><?php echo $name_result[0]['name'] ?></td>
                        <td><?php echo $value['quantity'] ?></td>
                        <td><?php echo $value['price'] ?></td>
                        <td>
                          <div class="btn-group">
                            <div class="container">
                              <a href="product_edit.php?id=<?php echo $value['id'] ?>" class="btn btn-primary">Edit</a>
                            </div>
                            <div class="container">
                              <a href="product_delete.php?id=<?php echo $value['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this item?')"
                                class="btn btn-danger">Delete</a>
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
