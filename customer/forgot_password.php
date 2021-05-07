<?php
require_once ('include/DB.php');
require_once ('include/session.php');
require_once ('include/function.php');
require_once ('include/sendmail.php');
ob_start();
if (isset($_POST['forget_password'])){
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
        $sql = "SELECT * from customers_master where email =:eMail LIMIT 1";
        $stmt = $con->prepare($sql);
        $stmt->bindValue('eMail',$email);
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            $username = $row['ename'];
            $token = $row['token'];
        }
        $result = $stmt->rowcount();
        if ($result) {
            $url = 'http://'.$_SERVER['SERVER_NAME'].'/online_banking/customer/recover_password.php?token='.$token.'';
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
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot Password | Prime Bank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="login-page" style="min-height: 348.391px;">
    <div class="login-box">
        <div class="login-logo">
            <a href="forgot_password.php#"><b>Customer </b>Bank</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <?php
                echo SuccessMessage();
                echo ErrorMessage();
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" name="forget_password"  class="btn btn-primary btn-block">Request new password</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="login.php">Login</a>
                </p>
            </div>
        </div>
    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/adminlte.min.js"></script>



</body>

</html>