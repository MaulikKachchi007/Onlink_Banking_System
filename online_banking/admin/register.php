<?php
require_once ('include/DB.php');
require_once ('include/session.php');
require_once ('include/function.php');
?>
<?php
    if (isset($_POST['register'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        $cpwd = $_POST['rpwd'];
        if (empty($name) || empty($email) || empty($password) || empty($cpwd)){
            $_SESSION['error_message'] = "All Fill Must Be Required.";
            redirect('register.php');
        }elseif ($password != $cpwd){
            $_SESSION['error_message'] = "Password and Confirm Password Not Match.";
            redirect('register.php');
        }elseif (strlen($password) < 5 || strlen($password) > 10){
            $_SESSION['error_message'] = "Password Should Be at least 5 and more than 10 characters";
            redirect('register.php');
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error_message'] = "* Please enter Valid Email";
            redirect('register.php');
        }elseif (checkUserExists($email)) {
                $_SESSION['error_message'] = "User already exists";
                redirect('register.php');
        }else{
            global $con;
                $sql = "INSERT INTO employees_master (uname,email,pwd) VALUES(:unaMe,:Email,:Password)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':unaMe',$name);
            $stmt->bindValue(':Email',$email);
            $stmt->bindValue(':Password',$password);
            $result = $stmt->execute();
            if ($result){
                $_SESSION['success_message'] = "Account Created Successfully.";
            }else{
                $_SESSION['error_message'] = "Something went wrong. Try again.";
                redirect('register.php');
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Prime Bank </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="register.php"><b>Admin Login</b></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new Staff Account</p>
        <?php
            echo ErrorMessage();
            echo SuccessMessage();
        ?>
      <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Full name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="pwd" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="rpwd" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
     <div class="">
         <a href="login.php" class="text-center">I already have a Accounts</a>
     </div>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
