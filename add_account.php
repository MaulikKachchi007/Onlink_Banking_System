<?php
    include 'include/DB.php';
    include 'include/function.php';
    include 'include/footer.php';
    $_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
    confirm_login();
    if (isset($_POST["add_account"])) {
        $a_type = $_POST["account_type"];
        $balance = $_POST["account_balance"];
        $interest = $_POST["account_interest"];
        $prefix = $_POST["account_prefix"];
        $status = "active";
        if (empty($a_type) || empty($balance) || empty($interest) || empty($prefix)) {
            $_SESSION["error_message"] = "All must fill required.";
        }elseif ($a_type == "Select") {
            $_SESSION["error_message"] = "At least one input selected";
        }else {
            global $con;
            $sql = "INSERT INTO account_master (account_type,prefix,min_balance,interest,status) VALUES (:account_type,:prefix,:min_balance,:interest,:status)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':account_type',$a_type);
            $stmt->bindValue(':prefix',$prefix);
            $stmt->bindValue(':min_balance',$balance);
            $stmt->bindValue(':interest',$interest);
            $stmt->bindValue(':status',$status);
            $result = $stmt->execute();
            if ($result) {
                $_SESSION['success_message'] = "Account Added Successfully";
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
                                        <h1 class="text-dark">Add Account</h1>
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
                        <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="account_type">Account Type</label>
                                    <select class="form-control" name="account_type">
                                        <option value="Select" selected>Select</option>
                                        <option value="Saving Account">Saving Account</option>
                                        <option value="Current Account">Current Account</option>
                                        <option value="Salary Account">Salary Account</option>
                                        <option value="Student Account">Student Account</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="account_prefix">Account Prefix</label>
                                    <input class="form-control" name="account_prefix" placeholder="Account Prefix">
                                </div>
                                <div class="form-group">
                                    <label for="account_balance">Account Balance</label>
                                    <input class="form-control" name="account_balance" placeholder="Opening Balance">
                                </div>
                                <div class="form-group">
                                    <label for="account_interest">Account Interest</label>
                                    <input class="form-control" name="account_interest" placeholder="Interest">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="add_account" class="btn btn-primary">Add Record</button>
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