
<?php
session_start();
require 'config/config.php';
require 'config/common.php';

if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>alert('please login first.');window.location.href='login.php'</script>";
}
if($_SESSION['role'] != 1 ){
  echo "<script>alert('Must be Admin Account..');window.location.href='login.php'</script>";
}

if($_POST){
if (empty($_POST['name']) || empty($_POST['description'])){

  if (empty($_POST['name'])){
    $nameError = 'Please fill category name';
  }


  if(empty($_POST['description'])){
    $descriptionError = 'Please fill description ';
  }

}else {

  $name = $_POST['name'];
  $description = $_POST['description'];
  $pdo_statement = $pdo->prepare( " INSERT INTO categories (name,description) VALUES (:name,:description) " );
  $result = $pdo_statement->execute(
    array(
      ':name' =>$name,
      ':description' => $description,
    )
  );
  // print"<pre>";
  // print_r($result); exit();
  echo"<script>alert('Successfully created..');window.location.href='category.php';</script>";
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
              <div class="card-body">
                <form class="" action="create_cat.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="Name">Title</label>
                    <p style="color:blue;"><?php echo empty($nameError) ? '': $nameError ?></p>
                    <input class="form-control" type="text" name="name" value="">
                    </div>

                    <div class="form-group">
                      <label for="Description">Content</label>
                      <p style="color:blue;"><?php echo empty($descriptionError) ? '': $descriptionError ?></p>
                      <textarea class="form-control" name="description" rows="8" cols="80"></textarea>
                      </div>

                      <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="title" value="Submit">
                        <a href="category.php" class="btn btn-info">Back</a>
                        </div>
                  </div>
                </form>
              </div>
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
