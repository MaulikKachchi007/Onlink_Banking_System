<?php
include('include/DB.php');
include('include/session.php');
include('include/function.php');
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id  = $_SESSION['id'];
global $con;
$sql = "SELECT * FROM employees_master WHERE id='$get_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()){
    $ifsccode = $row['ifsccode'];
}
$sql = "SELECT * FROM branch WHERE ifsccode='$ifsccode'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $bname = $row['bname'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $country = $row['country'];
}
?>
<?php
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';
?>

<!-- Navbar -->
<!-- Contact Banner -->

<!-- Contact Banner -->
<!-- Page Content -->
<div class="content-wrapper">
    <section class="content">
        <section class="google-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14878.701598242498!2d72.8305618697754!3d21.205049999999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04ef7674fff97%3A0x661c43bb36fd3ad3!2sKlick%20Digital%20Imagine!5e0!3m2!1sen!2sin!4v1605456703699!5m2!1sen!2sin" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </section>
<section class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            Main Branch
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title"><p class="text text-center" style="text-center'">Octo Prime E-Banking</p></h5>
                            <div class="card-text">
                                <i class="fa fa-location-arrow"></i>  SH 602, Shreeji Nagar-2, Uttran Station
                                <br> Surat <br>
                                Surat-395008, Gujarat <br>
                                <i class="fa fa-mail-forward"></i>  <b>Email To : </b>admin@admin.com <br>
                                <i class="fa fa-phone"></i> <b>Phone : </b>+91 9537706261
                                </p>
                            </div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="card">
                        <div class="card-header">
                            Office Branch
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title"><p class="text text-center">Octo Prime E-Banking</p></h5>
                            <div class="card-text">
                                <i class="fa fa-location-arrow"></i>  <?php echo $address;  ?>
                                  <br> <?php echo $bname; ?> <br>
                                 <?php echo $city; ?> <?php echo $state; ?> <br>
                                Time : Monday To Saturday ,9:00AM - 5:00PM<br>
                                <i class="fa fa-mail-forward"></i>  <b>Email To : </b>admin@admin.com <br>
                                <i class="fa fa-phone"></i> <b>Phone : </b>+91 9537706261
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
    </section>
</div>
<!-- Page Content -->

<!-- Copy -->
<?php
include 'include/footer.php';
?>