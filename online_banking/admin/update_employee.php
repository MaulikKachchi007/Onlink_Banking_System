<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST["update_employee"])) {
    $get_id = $_GET['id'];
    $ifsc_code = $_POST["branch"];
    $emp_name = $_POST["emp_name"];
    $l_id = $_POST["l_id"];
    $email = $_POST["email"];
    $mno = $_POST["mno"];
    $e_type = $_POST["e_type"];;
    if (empty($ifsc_code) || empty($emp_name) || empty($l_id) || empty($email) || empty($mno) || empty($e_type)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
        $sql = "Update employees_master SET ifsccode='$ifsc_code',ename='$emp_name',loginid='$l_id',email='$email',contact='$mno',employee_type='$e_type' WHERE id='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();;
        if ($result) {
            $_SESSION['success_message'] = "Employee Updated Successfully";
            redirect('view_employee.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";

        }
    }
}
global $con;
$q = "SELECT * FROM  employees_master WHERE id='$get_id'";
$stmt = $con->query($q);
$res = $stmt->execute();
while ($row = $stmt->fetch()) {
    $icode = $row['ifsccode'];
    $ename = $row['ename'];
    $loginid = $row['loginid'];
    $email = $row['email'];
    $phone = $row['contact'];
    $employee_type= $row['employee_type'];
    $status = $row['status'];
}
?>
<?php
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';
?>
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
                                            <h1 class="text-dark">Update Branch</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Update Branch</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_employee.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="update_employee.php?id=<?php echo $get_id; ?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="emp_name">Branch</label>
                                        <select class="form-control" name="branch">
                                            <option value="<?php echo $icode; ?>" selected><?php echo $icode; ?></option>
                                            <?php
                                            global $con;
                                            $q = "SELECT * FROM branch";
                                            $stmt = $con->query($q);
                                            $stmt->execute();
                                            while ($row = $stmt->fetch()) {
                                                $icode = $row['ifsccode'];
                                                $branch_name = $row['bname'];
                                                $add = $row['address'];
                                                $state = $row['state'];
                                                $country = $row['country'];
                                                ?>
                                                echo '<option value="<?php echo $icode; ?>"><?php echo $branch_name; ?> (<?php echo $icode; ?>) <?php echo $add;?>  <?php echo $state; ?> <?php echo $country; ?></option>';
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="emp_name">Employee Name</label>
                                        <input class="form-control" type="text" value="<?php echo $ename; ?>" name="emp_name" placeholder="Employee Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="loginid">Login ID</label>
                                        <input class="form-control" type="text" value="<?php echo $loginid; ?>" name="l_id" placeholder="Login ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email ID</label>
                                        <input class="form-control" type="email" value="<?php echo $email; ?>" name="email" placeholder="Email ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Contact Number</label>
                                        <input class="form-control" type="text" name="mno" value="<?php echo $phone; ?>" placeholder="Contact Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="e_type">Employee Type</label>
                                        <select class="form-control" name="e_type">
                                            <option value="<?php echo $employee_type; ?>" selected><?php echo $employee_type; ?></option>
                                            <option value="Admin" >Admin</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Staff" >Staff</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="update_employee" class="btn btn-primary">Update Employee</button>
                                    </div>
                                </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php
include 'include/footer.php';
?>