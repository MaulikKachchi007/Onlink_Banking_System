<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
if (isset($_POST["add_loan"])) {
    $l_type = $_POST["loan_type"];
    $loan_min_balance = $_POST["loan_min_balance"];
    $loan_max_balance = $_POST["loan_max_balance"];
    $interest = $_POST["loan_interest"];
    $loan_terms = $_POST["loan_terms"];
    $prefix = $_POST["loan_prefix"];
    $status = $_POST["status"];
    if (empty($l_type) || empty($loan_min_balance) || empty($loan_terms) || empty($loan_max_balance) || empty($interest) || empty($prefix)) {
        $_SESSION["error_message"] = "All must fill required.";
    }elseif ($l_type == "Select" || $status=="Select") {
        $_SESSION["error_message"] = "At least one input selected";
    }else {
        global $con;
        $sql = "INSERT INTO loan_type_master(loan_type,prefix,min_amt,max_amt,interest,terms,status) VALUES (:loan_type,:prefix,:min_balance,:max_balance,:interest,:terms,:status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':loan_type',$l_type);
        $stmt->bindValue(':prefix',$prefix);
        $stmt->bindValue(':min_balance',$loan_min_balance);
        $stmt->bindValue(':max_balance',$loan_max_balance);
        $stmt->bindValue(':interest',$interest);
        $stmt->bindValue(':terms',$loan_terms);
        $stmt->bindValue(':status',$status);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Loan Type Added Successfully";
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
        }
    }
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
                                            <h1 class="text-dark">Add Loan</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Loan</li>
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
                                        <label for="loan_type">Loan Type</label>
                                        <select class="form-control" name="loan_type">
                                            <option value="Select" selected>Select</option>
                                            <option value="Home Loan">Home Loan</option>
                                            <option value="Car Loan">Car Loan</option>
                                            <option value="Personal Loan">Personal Loan</option>
                                            <option value="Gold Loan">Gold Loan</option>
                                            <option value="Payday Loan">Payday Loan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="loan_prefix">Loan Prefix</label>
                                        <input class="form-control" name="loan_prefix" placeholder="Loan Prefix">
                                    </div>
                                    <div class="form-group">
                                        <label for="loan_min_balance">Loan Minimum Balance</label>
                                        <input class="form-control" name="loan_min_balance" placeholder="Loan Minimum Balance">
                                    </div>
                                    <div class="form-group">
                                        <label for="loan_max_balance">Loan Maximum Balance</label>
                                        <input class="form-control" name="loan_max_balance" placeholder="Loan Maximum Balance">
                                    </div>
                                    <div class="form-group">
                                        <label for="loan_interest">Loan Interest</label>
                                        <input class="form-control" name="loan_interest" placeholder="Interest">
                                    </div>
                                    <div class="form-group">
                                        <label for="loan_interest">Loan Terms</label>
                                        <input class="form-control" name="loan_terms" placeholder="Terms">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="None" selected>None</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="add_loan" class="btn btn-primary">Add Record</button>
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
