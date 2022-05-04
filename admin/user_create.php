<?php
session_start();
require "config/config.php";
require "config/common.php";


if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) && empty($_SESSION['user_name'])){
  echo "<script>window.location.href='login.php'</script>";
}

if($_SESSION['role'] != 1 ){
  echo "<script>alert('Must be Admin Account..');window.location.href='login.php';</script>";
}

if (!empty($_POST)) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $liveIn = $_POST['liveIn'];
  $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
  if (empty($_POST['role'])){
    $role = 0;
  }else{
    $role = 1;
  }

  if ( empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['liveIn']) || (!empty($_POST['password']) && (strlen($_POST['password'])<4)) ) {

    if (empty($_POST['name'])){
      $nameError = 'User name must not be empty. . .';
    }
    if (empty($_POST['email'])){
      $emailError = 'User email address must not be empty. . .';
    }
    if (empty($_POST['password'])){
      $passwordError = 'User password must not be empty. . .';
    }

    if (!empty($_POST['password']) &&  (strlen($_POST['password'])<4) ){
      $passwordError = 'User should use password character at least four.. . .';
    }

    if (empty($_POST['liveIn'])){
      $liveInError = 'Please insert your living address. . .';
    }

  }else {
    // echo " this is a time ";
    $pdo_stmt = $pdo->prepare(" SELECT * FROM users WHERE email= :email");
    $pdo_stmt->execute(
      array(
        ':email' => $email
      )
    );
    $email_result = $pdo_stmt->fetchAll();
    print"<pre>";
    print_r($email_result);

    if ($email_result){
      echo "<script>alert('your email is duplicated. . . ');</script>";
    }else {

    $pdo_statement = $pdo->prepare(" INSERT INTO users(name,email,password,address,role) VALUES (:name,:email,:password,:address,:role) ");
    $pdo_statement->execute(
      array(
        ':name'=> $name,
        ':email' => $email,
        ':password' => $password,
        ':address' => $liveIn,
        ':role' => $role
      )
    );
      echo "<script>alert('Successfully created. . . ');window.location.href='user_List.php';</script>";
    }
  }


}
 ?>


<?php
include('header.php');
 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Admin Panel </title>
   <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
   <!-- Ionicons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- icheck bootstrap -->
   <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="dist/css/adminlte.min.css">
   <!-- Google Font: Source Sans Pro -->
   <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
 </head>
 <body class="hold-transition login-page">
   <div class="container">
     <div class="row">
       <div class="login-box col-8" style="margin: 0 auto;">
         <!-- /.login-logo -->
         <div class="card card-info">
           <div class="card-header" >
             <h3 class="card-title" style="float:none !important; text-align:center;">User Account Creation Form</h3>
           </div>
           <!-- /.card-header -->
           <!-- form start -->
           <form class="" action="user_create.php" method="post" >
             <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
             <div class="card-body">
               <div class="form-group ">
                 <label for="Name" class="col-form-label">Name</label>
                 <p style="color:red;"><?php echo empty($nameError) ? '' : $nameError ?></p>
                   <input type="text" name="name" class="form-control"  placeholder="Name" >
                 </div>
                 <div class="form-group ">
                   <label for="email" class="col-form-label">Email</label>
                   <p style="color:red;"><?php echo empty($emailError) ? '' : $emailError ?></p>
                     <input type="email" name="email" class="form-control"   placeholder="Email">
                 </div>
                 <div class="form-group ">
                   <label for="password" class="col-form-label">Password</label>
                   <p style="color:red;"><?php echo empty($passwordError) ? '' : $passwordError ?></p>
                     <input type="password" name="password" class="form-control" id="" placeholder="Password" >
                 </div>
                 <div class="form-group ">
                   <label for="liveIn" class="col-form-label">Live In</label>
                   <p style="color:red;"><?php echo empty($liveInError) ? '' : $liveInError ?></p>
                     <input type="text" name="liveIn" class="form-control" id="" placeholder="Live In" >
                 </div>
                 <div class="form-group ">
                     <div class="form-check" style="padding-left:0px !important;">
                       <input type="checkbox" class="" name="role" >
                       <label class="form-check-label" for=""> Create Admin Account </label>
                     </div>
                 </div>
               </div>
               <div class="card-footer">
                 <button type="submit" class="btn btn-info">Create</button>
                 <a href="user_list.php" type="button" class="btn btn-success" style="float:right;" >Back</a>
               </div>
             </div>
           </form>
         </div>
     </div>
   </div>



 <!-- /.login-box -->

 <!-- jQuery -->
 <script src="plugins/jquery/jquery.min.js"></script>
 <!-- Bootstrap 4 -->
 <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
 <!-- AdminLTE App -->
 <script src="dist/js/adminlte.min.js"></script>

 </body>
 </html>

 <?php
include('footer.html');
  ?>
