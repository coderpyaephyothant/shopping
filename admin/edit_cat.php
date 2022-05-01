
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

if(!empty($_POST)){
  $name = $_POST['name'];
  $description = $_POST['description'];
  $id = $_POST['id'];
if (empty($_POST['name']) || empty($_POST['description'])){

  if (empty($_POST['name'])){
    $nameError = 'Please fill category name';
  }

  if(empty($_POST['description'])){
    $descriptionError = 'Please fill description ';
  }

}else {


  $pdo_statement = $pdo->prepare( " UPDATE categories SET name=:name, description=:description WHERE id='$id'" );
  $result = $pdo_statement->execute(
    array(
      ':name' =>$name,
      ':description' => $description,
    )
  );
  // print"<pre>";
  // print_r($result); exit();
  echo"<script>alert('Successfully updated..');window.location.href='category.php';</script>";
}

}

$pdo_statement1 = $pdo->prepare(" SELECT * FROM categories WHERE id=".$_GET['id']);
$pdo_statement1->execute();
$data_for_edit_ById = $pdo_statement1->fetchAll();
// print"<pre>";
// print_r($data_for_edit_ById); exit();
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
                <form class="" action="edit_cat.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                  <input type="hidden" name="id" value="<?php echo $data_for_edit_ById[0]['id'] ?>">
                  <div class="form-group">
                    <label for="Name">Name</label>
                    <p style="color:blue;"><?php echo empty($nameError) ? '': $nameError ?></p>
                    <input class="form-control" type="text" name="name" value="<?php echo $data_for_edit_ById[0]['name'] ?>">
                    </div>

                    <div class="form-group">
                      <label for="Description">Description</label>
                      <p style="color:blue;"><?php echo empty($descriptionError) ? '': $descriptionError ?></p>
                      <textarea class="form-control" name="description" rows="8" value="" cols="80"><?php echo $data_for_edit_ById[0]['description'] ?></textarea>
                      </div>

                      <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="" value="Submit">
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
