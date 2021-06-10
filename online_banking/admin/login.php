<?php
require_once ('include/DB.php');
require_once ('include/session.php');
require_once ('include/function.php');
?>
<?php
if(isset($_SESSION["id"])){
    Redirect("index.php");
}
if (isset($_POST['login'])){
    $login_id = $_POST['login_id'];
    $password = $_POST['pwd'];
    if (empty($login_id) || empty($password)){
        $_SESSION['error_message'] = "All Fill Must Be Required.";
        redirect('login.php');
    }else{
        // Checking Username and Passsword from database
        $found_account = login_attempt($login_id,$password);
        if ($found_account){
            $_SESSION['id'] = $found_account['id'];
            $_SESSION['loginid'] = $found_account['loginid'];
            $_SESSION['ename'] = $found_account['ename'];
            $_SESSION['success_message'] = "Welcome to ".$_SESSION["ename"]."!";
            if (isset($_SESSION['TrackingURL'])) {
                redirect($_SESSION['TrackingURL']);
            }else{
                redirect('index.php');
            }
        }else{
            $_SESSION['error_message'] = "Incorrect Username or Password.";
            redirect('login.php');
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Log in</title>
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
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href=""><b>Admin</b>Login</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to Admin Login</p>
            <?php
                echo ErrorMessage();
                echo SuccessMessage();
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="login_id" placeholder="Login ID">
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
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" name="login" class="btn btn-primary btn-block">Sign In</button>
                </div>
            </form>

            <p class="mb-1">
                <a href="forgot_password.php">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="register.php" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>

</body>
</html>
