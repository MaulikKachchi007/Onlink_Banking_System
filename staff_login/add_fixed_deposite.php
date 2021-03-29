<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
if (isset($_POST["add_deposite"])) {
    $d_type = $_POST["deposite_type"];
    $min_amount = $_POST["min_amt"];
    $max_amount = $_POST["max_amt"];
    $interest = $_POST["deposite_interest"];
    $prefix = $_POST["deposite_prefix"];
    $terms = $_POST["terms"];
    $status = $_POST["status"];
    if (empty($d_type) || empty($min_amount) || empty($max_amount) || empty($interest) || empty($prefix) || empty($status) || empty($terms)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
        $sql = "INSERT INTO fixed_deposite (d_type,prefix,min_amt,max_amt,interest,terms,status) VALUES (:d_type,:prefix,:min_amt,:max_amt,:interest,:terms,:status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':d_type',$d_type);
        $stmt->bindValue(':prefix',$prefix);
        $stmt->bindValue(':min_amt',$min_amount);
        $stmt->bindValue(':max_amt',$min_amount);
        $stmt->bindValue(':interest',$interest);
        $stmt->bindValue(':terms',$terms);
        $stmt->bindValue(':status',$status);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Fixed Deposite Added Successfully";
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
                                            <h1 class="text-dark">Add Deposite</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Deposite</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_deposite.php" class="btn btn-info float-right text-white">View Record</a>
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
                                        <label for="Deposite_type">Deposite Type</label>
                                        <select class="form-control" name="deposite_type">
                                            <option value="Select" selected>Select</option>
                                            <option value="Double Plan">Double Plan</option>
                                            <option value="Lakhs Plan">Lakhs Plan</option>
                                            <option value="One Time FD">One Time FD</option>
                                            <option value="Senior Citizen Plan">Senior Citizen Plan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Deposite_prefix">Deposite Prefix</label>
                                        <input class="form-control" name="deposite_prefix" placeholder="Deposite Prefix">
                                    </div>
                                    <div class="form-group">
                                        <label for="min_amt">Minimum Amount</label>
                                        <input class="form-control" name="min_amt" placeholder="Minimum Amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="max_amt">Maximum Amount</label>
                                        <input class="form-control" name="max_amt" placeholder="Maximum Amount">
                                    </div>
                                    <div class="form-group">
                                        <label for="deposite_interest">Interest(In percentage %)</label>
                                        <input class="form-control" name="deposite_interest" placeholder="Interest">
                                    </div>
                                    <div class="form-group">
                                        <label for="terms">Terms(No of Year)</label>
                                            <input class="form-control" name="terms" placeholder="Terms">
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
                                        <button type="submit" name="add_deposite" class="btn btn-primary">Add Deposite</button>
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
?><?php
