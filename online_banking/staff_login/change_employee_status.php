<?php
include('include/DB.php');
//include('include/session.php');
include('include/function.php');

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST['verify_emp'])) {
    global $con;
    $qr = "SELECT * FROM employees_master WHERE id='$get_id'";
    $stmt = $con->query($qr);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $change_status = $row['status'];
    }
    if ($change_status == 'Inactive') {
        $sql = "Update employees_master SET status='Active' WHERE id='$get_id'";
        $stmt = $con->query($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Employee Verify.!";
            redirect('view_employee.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_employee.php');
        }
    }
    elseif ($change_status == 'Active') {
        $sql = "Update employees_master SET status='Inactive' WHERE id='$get_id'";
        $stmt = $con->query($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Employee Un-Verify.!";
            redirect('view_employee.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_employee.php');
        }
    }
}

?>
<?php
global $con;

$qr = "SELECT * FROM employees_master WHERE id='$get_id'";
$stmt = $con->query($qr);
$result = $stmt->execute();
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
include('include/header.php');
include('include/topbar.php');
include('include/sidebar.php');
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
                                            <h1 class="text-dark">Verify Account</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Verify Account</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="customers_detail.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>IFSC Code</th>
                                    <td><?php echo $icode; ?></td>
                                </tr>
                                <tr>
                                    <th>Employee Name</th>
                                    <td><?php echo $ename; ?></td>
                                </tr>
                                <tr>
                                    <th>Login ID</th>
                                    <td><?php echo $loginid; ?></td>
                                </tr>
                                <tr>
                                    <th>Email ID</th>
                                    <td><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <th>Contact</th>
                                    <td><?php echo $phone; ?></td>
                                </tr>
                                <tr>
                                    <th>Employee Type</th>
                                    <td><?php echo $employee_type; ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo $status; ?></td>
                                </tr>
                                <tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <form method="post" action="change_employee_status.php?id=<?php echo $get_id; ?>">
                                            <?php if ($status == "Active") {
                                                ?>
                                                <button type="submit" name="verify_emp" onclick="confirm('Connfirm Verify Account');" class="btn btn-danger">Un-Verify Account</button>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <button type="submit" name="verify_emp" onclick="confirm('Connfirm Verify Account');" class="btn btn-success">Verify Account</button>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                </tr>
                            </table>
                        </div>
                </div>
            </div>
        </section>
    </div>

<?php
include('include/footer.php');
?>