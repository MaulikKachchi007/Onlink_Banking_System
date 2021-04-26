<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST["update_register"])) {
    $get_id = $_GET['id'];
    $ifsc_code = $_POST['ifsc_code'];
    $payee_name = $_POST['payee_name'];
    $bank_account_number = $_POST['bank_account_number'];
    $bank_name = $_POST['bank_name'];
    $account_type = $_POST['account_type'];
    if (empty($ifsc_code) || empty($payee_name) || empty($bank_account_number) || empty($bank_name) || empty($account_type)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
        $sql = "Update registered_payee SET payee_name='$payee_name',account_no ='$bank_account_number',account_type ='$account_type',bank_name='$bank_name',ifsccode='$ifsc_code' WHERE registered_payee_id ='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Registered Payee     Updated Successfully";
            redirect('viewcustregisteredpayee.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";

        }
    }
}
global $con;
$q = "SELECT * FROM  registered_payee WHERE registered_payee_id ='$get_id' and status='Active'";
$stmt = $con->query($q);
$res = $stmt->execute();
while ($row = $stmt->fetch()) {
    $ifsccode = $row['ifsccode'];
    $registered_payee_type = $row['registered_payee_type'];
    $payee_name = $row['payee_name'];
    $account_no  = $row['account_no'];
    $account_type  = $row['account_type'];
    $bank_name= $row['bank_name'];
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
                                            <h1 class="text-dark">Update Registered Payee</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Update Registered Payee</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="viewcustregisteredpayee.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="update_custregisteredpayee.php?id=<?php echo $get_id; ?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="payee_name">Payee Name</label>
                                        <input class="form-control" type="text" value="<?php echo $payee_name; ?>" name="payee_name" placeholder="Payee Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_account_number">Bank Account Number</label>
                                        <input class="form-control" type="text" value="<?php echo $account_no; ?>" name="bank_account_number" placeholder="Account Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="bank_name">Bank Name</label>
                                        <input class="form-control" type="text" value="<?php echo $bank_name; ?>" name="bank_name" placeholder="Account Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="ifsc_code">IFSC Code</label>
                                        <input class="form-control" type="text" value="<?php echo $ifsccode; ?>" name="ifsc_code" placeholder="IFSC Code">
                                    </div>
                                    <div class="form-group">
                                        <label for="account_type">Account Type</label>
                                        <select class="form-control" name="account_type">
                                            <option value="<?php echo $account_type; ?>" selected><?php echo $account_type; ?></option>
                                            <?php
                                            global $con;
                                            $q = "SELECT * FROM account_master";
                                            $stmt = $con->query($q);
                                            while ($row = $stmt->fetch()) {
                                                $acc_type = $row['account_type'];
                                                ?>
                                                <option value="<?php echo $acc_type; ?>"><?php echo $acc_type; ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="update_register" class="btn btn-primary">Update Registered Payee</button>
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