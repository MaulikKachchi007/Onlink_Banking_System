<?php
require_once('include/DB.php');
require_once('include/session.php');
require_once('include/function.php');

$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST['verify_account'])) {
    global $con;
    $qr = "SELECT * FROM customers_master WHERE c_id='$get_id'";
    $stmt = $con->query($qr);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        $change_status = $row['accountstatus'];
    }
//    echo $change_status;
//    die();
    if ($change_status == 'Inactive') {
        $sql = "Update customers_master SET accountstatus='active' WHERE c_id='$get_id'";
        $stmt = $con->query($sql);
        $result= $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Account Verify.!";
            redirect('customers_detail.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('customers_detail.php');
        }
    }
    elseif ($change_status == 'active') {
        $sql = "Update customers_master SET accountstatus='Inactive' WHERE c_id='$get_id'";
        $stmt = $con->query($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Account Un-Verify.!";
            redirect('customers_detail.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('customers_detail.php');
        }
    }
}

?>
<?php
global $con;
$q = "SELECT * FROM customers_master WHERE c_id='$get_id'";
$stmt = $con->query($q);
while ($row = $stmt->fetch()) {

    $custid = $row['c_id'];
    $f_name = $row['f_name'];
    $l_name = $row['l_name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $area = $row['ifsccode'];
    $pincode = $row['pincode'];
    $city = $row['city'];
    $adharnumber = $row['adharnumber'];
    $gender = $row['gender'];
    $birthdate = $row['birthdate'];
    $occuption = $row['occuption'];
    $account_type = $row['account_type'];
    $accounts_status = $row['accountstatus'];

}

?>
<?php
require_once('include/header.php');
require_once('include/topbar.php');
require_once('include/sidebar.php');
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
                                    <th>ID</th>
                                    <td><?php echo $custid; ?></td>
                                </tr>
                                <tr>
                                    <th>First Name</th>
                                    <td><?php echo $f_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><?php echo $l_name; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <th>Mobile No</th>
                                    <td><?php echo $phone; ?></td>
                                </tr>
                                <tr>
                                    <th>Account Type</th>
                                    <td><?php echo $account_type; ?></td>
                                </tr>
                                <tr>
                                    <th>Area</th>
                                    <td><?php echo $area; ?></td>
                                </tr>
                                <tr>
                                    <th>Pincode</th>
                                    <td><?php echo $pincode; ?></td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td><?php echo $city; ?></td>
                                </tr>
                                <tr>
                                    <th>Adhar Number</th>
                                    <td><?php echo $adharnumber; ?></td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td><?php echo $gender; ?></td>
                                </tr>
                                <tr>
                                    <th>Occupation</th>
                                    <td><?php echo $occuption; ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <form method="post" action="change_customer_status.php?id=<?php echo $custid; ?>">
                                            <?php if ($accounts_status == "active") {
                                                ?>
                                                <button type="submit" name="verify_account" onclick="confirm('Connfirm Verify Account');" class="btn btn-danger">Un-Verify Account</button>
                                                <?php
                                            }
                                            else if ($accounts_status == "Inactive") {
                                                ?>
                                                <button type="submit" name="verify_account" onclick="confirm('Connfirm Verify Account');" class="btn btn-success">Verify Account</button>
                                                <?php
                                            }
                                            ?>
                                        </form>
                                        <!-- /.card -->
                                        </td>
                                </tr>
                            </table>
                        </div>
                </div>
            </div>

        </section>
    </div>

<?php
require_once('include/footer.php');
?>