<?php
require_once ('include/DB.php');
require_once ('include/session.php');
require_once ('include/function.php');
require_once ('include/sendmail.php');
ob_start();
?>
<?php
    if (isset($_POST['forgot_password'])){
        $email = $_POST['email'];
        if (empty($email)) {
            $_SESSION['error_message'] = "All fields are required.";
            redirect('forgot_password.php');
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Please enter a valid email.";
        redirect('forgot_password.php');
        }else{
            #Request for Email code and check email
            global $con;
            $sql = "SELECT * from employees_master where email =:eMail LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->bindValue('eMail',$email);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $username = $row['ename'];
                $token = $row['token'];
            }
            $result = $stmt->rowcount();
            if ($result) {
                $url = 'http://'.$_SERVER['SERVER_NAME'].'/online_banking/admin/recover_password.php?token='.$token.'';
                $output = "Hi,Dear $username, Please Click here to change your password.<br>" . $url;
                $subject = "Reset Password";
                sendmail($email,$subject, $output, "OctoPrime E-Banking");
                    $_SESSION['success_message'] = "Email sent successfully";
                    redirect('login.php');

            }else{
                $_SESSION["error_message"] = "Something went wrong! Try again later.";
                redirect('forgot_password.php');
            }
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Forgot Password</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets//plugins/fontawesome-free/css/all.min.css">
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
        <a href="#"><b>Admin </b>Login</a>
    </div>

    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
            <?php
            echo SuccessMessage();
            echo ErrorMessage();
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="email" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" name="forgot_password" class="btn btn-primary btn-block">Request new password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="login.php">Login</a>
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
