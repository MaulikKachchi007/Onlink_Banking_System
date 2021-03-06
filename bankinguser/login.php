<?php
include_once "include/DB.php";
include_once "include/session.php";
include_once "include/function.php";

if (isset($_POST['submit'])) {

    if(isset($_SESSION["id"])){
        Redirect("index.php");
    }
    
    if (isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        if (empty($email) || empty($password)){
            $_SESSION['error_message'] = "All Fill Must Be Required.";
            redirect('login.php');
        }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error_message'] = "* Please enter Valid Email";
            redirect('login.php');
        }else{
            // Checking Username and Passsword from database
            $found_account = login_attempt($email,$password);
            if ($found_account){
                $_SESSION['id'] = $found_account['id'];
                $_SESSION['email'] = $found_account['email'];
                $_SESSION['uname'] = $found_account['uname'];
                $_SESSION['success_message'] = "Welcome to ".$_SESSION["uname"]."!";
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

    if ($flag) {
        $query = "SELECT * FROM user_login WHERE usermail='$usermail'";
        // echo $query;

        $isLive = $con->query($query)->fetch() or die("Somthing Wrong");


        if (@is_array($isLive)) {
            $USERNAME = $isLive['username'];
            $USERMAIL =  $isLive['usermail'];
            $PASSWORD = $isLive['userpassword'];
            $userimg = $isLive['userimg'];
            if (password_verify($userpassword, $PASSWORD)) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $USERNAME;
                $_SESSION['usermail'] = $USERMAIL;
                $_SESSION['userimg'] = $userimg;
                header('Location: index.php ');
            } else {
                $errorStatus = true;
                $errorMeggage = "!...Incorrect Password";
            }
        } else {
            $errorStatus = true;
            $errorMeggage = "!...No record found";
        }
    } else {
        $errorStatus = true;
        $errorMeggage = "!...All Field Required";
    }
}

?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in | Prime Bank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="login-page" style="min-height: 512.391px;">
    <div class="login-box">
        <div class="login-logo">
            <b>Log In</b> Here
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <?php
                if ($errorStatus) {
                    echo "<div class='alert alert-warning' role='alert'>'$errorMeggage'</div>";
                }
                ?>
                <form action="./login.php" method="post">
                    <div class="input-group mb-3">
                        <input type="email" name="usermail" value='<?= $usermail ?>' class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"><?= $e_usermail ? ' | <i style="color:red;" class="fa fa-info-circle" aria-hidden="true"></i>' : ""   ?>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" value='<?= $userpassword ?>' name="userpassword" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"><?= $e_userpassword ? ' | <i style="color:red;" class="fa fa-info-circle" aria-hidden="true"></i>' : '' ?>
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
                        <div class="col-4">
                            <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>


                <p class="mb-1">
                    <a href="forgot-password.php">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="register.php" class="text-center">Register a new membership</a>
                </p>
            </div>
        </div>
    </div>

    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/adminlte.min.js"></script>



</body>
</html>