<?php
include('include/DB.php');
include('include/session.php');
include('include/function.php');
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
$get_id = $_SESSION['id'];
confirm_login();
if (isset($_POST["update_employee"])) {
$emp_name = $_POST["ename"];
$l_id = $_POST["l_id"];
$email = $_POST["email"];
$mno = $_POST["mno"];
if (empty($emp_name) || empty($l_id) || empty($email) || empty($mno)) {
    $_SESSION["error_message"] = "All must fill required.";
}else {
    global $con;
    $sql = "Update employees_master SET ename='$emp_name',loginid='$l_id',email='$email',contact='$mno' WHERE id='$get_id'";
    $stmt = $con->prepare($sql);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['success_message'] = "Employee Updated Successfully";
        redirect('index.php');
    } else {
        $_SESSION['error_message'] = "Something went wrong. Try again!";
    }
}
}
?>
<?php
    global $con;
    $sql = "SELECT * FROM employees_master WHERE id='$get_id'";
    $stmt= $con->query($sql);
    $result = $stmt->execute();
    if ($row = $stmt->fetch()) {
        $ifsccode = $row['ifsccode'];
        $ename = $row['ename'];
        $loginid = $row['loginid'];
        $email = $row['email'];
        $contact = $row['contact'];
        $employee_type = $row['employee_type'];
    }
    $q = "SELECT * FROM branch WHERE ifsccode='$ifsccode'";
    $stmt = $con->query($q);
    $result = $stmt->execute();
    if ($row = $stmt->fetch()) {
        $bname = $row['bname'];
        $state = $row['state'];
        $city =  $row['city'];
        $address = $row['address'];
        $country = $row['country'];
    }
?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
?>
    <!-- Main content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card card-default mt-2">
                            <div class="card-header">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6 col-md-6">
                                            <h1 class="text-dark">Profile</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">User Profile</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_loan_type.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <select class="form-control" name="ifsc_code" disabled>
                                            <option value="<?php echo $ifsccode; ?>"  selected><?php echo $bname; ?>: (<?php echo $ifsccode;  ?> <?php echo $address; ?>,<?php echo $city; ?>, <?php echo $state; ?>, <?php echo $country ?>)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="emp_name">Employee Name</label>
                                        <input class="form-control" name="ename" value="<?php echo $ename; ?>" placeholder="Employee Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="loginid">Login ID</label>
                                        <input class="form-control" name="l_id" value="<?php echo $loginid; ?>" placeholder="Login Id">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email ID</label>
                                        <input class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="mno">Contact No</label>
                                        <input class="form-control" name="mno" value="<?php echo $contact; ?>" placeholder="Contact No">
                                    </div>
                                    <div class="form-group">
                                        <label for="e_type">Employee Type</label>
                                        <input class="form-control" name="e_Type" disabled value="<?php echo $employee_type; ?>" placeholder="Employee Type">
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="update_employee" class="btn btn-primary">Update Record</button>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content -->
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<?php
include 'include/footer.php';
?>