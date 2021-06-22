<?php
require_once ('include/DB.php');
require_once ('include/session.php');
require_once ('include/function.php');
ob_start();
?>
<?php
global $con;
$token = $_GET['token'];
$sql = "SELECT * FROM customers_master WHERE token='$token'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $email = $row['email'];
}
if (isset($_POST['recover_password'])){
    $old_password = base64_encode($_POST['old_password']);
    $new_password = base64_encode($_POST['new_password']);
    $confirm_Password = base64_encode($_POST['confirm_password']);
    if ($new_password != $confirm_Password) {
        $_SESSION['error_message'] = "Password and Confirm Password Not match.";
        redirect('recover_password.php');
    }elseif (strlen(base64_decode($new_password))  > 10) {
        $_SESSION['error_message'] = "Your Password  Less than 10 characters!";
        redirect('recover_password.php');
    }elseif(!preg_match("#[0-9]+#",base64_decode($new_password))) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Number!";
        redirect('recover_password.php');
    }elseif(!preg_match("#[A-Z]+#",base64_decode($new_password))) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Capital Letter!";
        redirect('recover_password.php');
    }elseif(!preg_match("#[a-z]+#",base64_decode($new_password))) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        redirect('recover_password.php');
    }elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', base64_decode($new_password))) {
        $_SESSION['error_message'] = "Your Password Must Contain At Least 1 Special Character !";
        redirect('recover_password.php');
    }
    else {
        #Request for Email code and check email
        global $con;
        $sql = "SELECT * from customers_master where email =:eMail AND password=:Old_PassWord";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':eMail', $email);
        $stmt->bindValue(':Old_PassWord', $old_password);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            $sql = "UPDATE customers_master SET password =:new_PassWord where email =:eMail";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':eMail', $email);
            $stmt->bindValue(':new_PassWord', $new_password);
            //$stmt->bindValue('Old_pAssWord',$old_password);
            $res = $stmt->execute();
            if ($res) {
                $_SESSION["success_message"] = "New Password Change successfully";
                redirect('login.php');
            } else {
                $_SESSION["error_message"] = "Incorrect New Password!";
                redirect('recover_password.php');
            }
        }else{
            $_SESSION["error_message"] = "Incorrect Old Password!";
            redirect('recover_password.php');
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Recover Password</title>
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
        <a href="#"><b>Reset</b>Password</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
            <?php
            echo SuccessMessage();
            echo ErrorMessage();
            ?>
            <form action="recover_password.php?token=<?php echo $token; ?>" method="post">
                <div class="input-group mb-3">
                    <input type="password" class="form-control"  name="old_password" placeholder="Old Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="new_password" placeholder="New Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" name="recover_password" class="btn btn-primary btn-block">Change password</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
