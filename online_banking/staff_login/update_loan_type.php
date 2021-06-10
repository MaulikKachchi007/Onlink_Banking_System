<?php
include 'include/DB.php';
include 'include/function.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST["update_loan_type"])) {
    $l_type = $_POST["loan_type"];
    $min_amount = $_POST["min_amount"];
    $max_amount = $_POST["max_amount"];
    $interest = $_POST["loan_interest"];
    $prefix = $_POST["loan_prefix"];
//        $status = "active";
    if (empty($l_type) || empty($min_amount)|| empty($max_amount) || empty($interest) || empty($prefix)) {
        $_SESSION["error_message"] = "All must fill required.";
    }elseif ($l_type == "Select") {
        $_SESSION["error_message"] = "At least one input selected";
    }else {
        global $con;
        $q =    "Update loan_type_master SET loan_type='$l_type',prefix='$prefix',min_amt='$min_amount',max_amt='$max_amount',interest='$interest' WHERE id='$get_id'";
        $stmt = $con->prepare($q);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Loan Update Successfully";
            redirect('view_loan_type.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
        }
    }
}
global $con;
$sql = "SELECT * from loan_type_master WHERE id ='$get_id'";
$stmt = $con->query($sql);
$result = $stmt->execute();
while ($row = $stmt->fetch()) {
    $l_type = $row['loan_type'];
    $prefix = $row['prefix'];
    $min_amount = $row['min_amt'];
    $max_amount = $row['max_amt'];
    $interest = $row['interest'];
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
                                            <h1 class="text-dark">Update Account</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Account</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_account.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="update_loan_type.php?id=<?php echo $get_id; ?>" method="post"

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="Loan_type">Loan Type</label>
                                    <select class="form-control" name="loan_type">
                                        <option value="<?php echo $l_type; ?>"><?php echo $l_type; ?></option>
                                        <option value="Home Loan">Home Loan</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Gold Loan">Gold Loan</option>
                                        <option value="Payday Loan">Payday Loan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="account_prefix">Loan Prefix</label>
                                    <input class="form-control" name="loan_prefix" value="<?php echo $prefix;?>" placeholder="Loan Prefix">
                                </div>
                                <div class="form-group">
                                    <label for="min_amount">Minimum Amount</label>
                                    <input class="form-control" name="min_amount" value="<?php echo $min_amount;?>" placeholder="Minimum Amount">
                                </div>
                                <div class="form-group">
                                    <label for="min_amount">Maximum Amount</label>
                                    <input class="form-control" name="max_amount" value="<?php echo $max_amount;?>" placeholder="Maximum Amount">
                                </div>
                                <div class="form-group">
                                    <label for="loan_interest">Loan Interest</label>
                                    <input class="form-control" name="loan_interest" value="<?php echo $interest; ?>" placeholder="Interest">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="update_loan_type" class="btn btn-primary">Update Record</button>
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
<?php
include 'include/footer.php';
?>