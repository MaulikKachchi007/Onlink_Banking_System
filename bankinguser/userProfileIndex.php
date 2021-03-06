<?php

include './../middlewares/Session_login.php';

require './../config/db.config.php';
$USERMAIL = $_SESSION['usermail'];

$query = "SELECT * FROM user_login WHERE usermail='$USERMAIL'";
$user = $con->query($query)->fetch();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Welcome To Prime Bank</title>

    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>


<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include './Layouts/Navbar-h.php'; ?>

        <?php include './Layouts/Navbar-v.php'; ?>

        <?php include './Layouts/editUserProfile.php'; ?>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>

        <?php include './Layouts/Footer.php'; ?>
    </div>


    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.js"></script>

    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
</body>

<script src="../view/custom/js/editUserProfile.js"></script>

</html>