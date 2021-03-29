<?php
include_once "include/DB.php";
include_once "include/session.php";
include_once "include/function.php";

if (isset($_POST['v_pin'])) {
    $email = $_GET['email'];
    if (isset($_SESSION["c_id"])) {
        Redirect("index.php");
    }

    if (isset($_POST['v_pin'])) {
        $v_pin = $_POST['v_pin'];
        if (empty($v_pin)) {
            $_SESSION['error_message'] = "All Fill Must Be Required.";
            redirect('login.php');
        } else {
            // Checking Username and Passsword from database
            $found_account = verify_account($v_pin);
            if ($found_account) {
                $_SESSION['id'] = $found_account['id'];
                $_SESSION['email'] = $found_account['email'];
                $_SESSION['f_name'] = $found_account['f_name'];
                $_SESSION['success_message'] = "Welcome to " . $_SESSION["f_name"] . "!";
                if (isset($_SESSION['TrackingURL'])) {
                    redirect($_SESSION['TrackingURL']);
                } else {
                    redirect('index.php');
                }
            } else {
                $_SESSION['error_message'] = "Incorrect Pin.";
                redirect('login.php');
            }
        }
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
                    echo ErrorMessage();
                    echo SuccessMessage();
                ?>
                <form role="form" action="verify_login.php?email=<?php echo $email;?>" method="post" id="quickForm">
                        <div class="form-group">
                            <input type="password" name="v_pin" class="form-control" id="exampleInputEmail1" placeholder="Enter Pin">
                        </div>
                       
                    <!-- /.card-body -->
                        <button type="submit" name="login" class="btn btn-primary btn-block">Verify Login</button> 
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- jquery-validation -->
    <script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/dist/js/demo.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#quickForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    terms: {
                        required: true
                    },
                },
                messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },

                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>
</html>