<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
    $_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
    confirm_login();
    $get_id = $_GET['id'];
    if (isset($_POST["update_account"])) {
        $a_type = $_POST["account_type"];
        $balance = $_POST["account_balance"];
        $interest = $_POST["account_interest"];
        $prefix = $_POST["account_prefix"];
//        $status = "active";
        if (empty($a_type) || empty($balance) || empty($interest) || empty($prefix)) {
            $_SESSION["error_message"] = "All must fill required.";
        }elseif ($a_type == "Select") {
            $_SESSION["error_message"] = "At least one input selected";
        }else {
            global $con;
            $q = "Update account_master SET account_type='$a_type',prefix='$prefix',min_balance='$balance',interest='$interest' WHERE id='$get_id'";
            $stmt = $con->prepare($q);
            $result = $stmt->execute();
            if ($result) {
                $_SESSION['success_message'] = "Account Update Successfully";
                redirect('view_account.php');
            }else{
                $_SESSION['error_message'] = "Something went wrong. Try again!";
            }
        }
    }
    global $con;
    $sql = "SELECT * from account_master WHERE id ='$get_id'";
    $stmt = $con->query($sql);
    $result = $stmt->execute();
    while ($row = $stmt->fetch()) {
        $a_type = $row['account_type'];
        $prefix = $row['prefix'];
        $min_amount = $row['min_balance'];
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
                        <form role="form" action="update_account.php?id=<?php echo $get_id; ?>" method="post"

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="account_type">Account Type</label>
                                    <select class="form-control" name="account_type">
                                        <option value="<?php echo $a_type; ?>"><?php echo $a_type; ?></option>
                                        <option value="Saving Account">Saving Account</option>
                                        <option value="Current Account">Current Account</option>
                                        <option value="Salary Account">Salary Account</option>
                                        <option value="Student Account">Student Account</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="account_prefix">Account Prefix</label>
                                    <input class="form-control" name="account_prefix" value="<?php echo $prefix;?>" placeholder="Account Prefix">
                                </div>
                                <div class="form-group">
                                    <label for="account_balance">Account Balance</label>
                                    <input class="form-control" name="account_balance" value="<?php echo $min_amount;?>" placeholder="Opening Balance">
                                </div>
                                <div class="form-group">
                                    <label for="account_interest">Account Interest</label>
                                    <input class="form-control" name="account_interest" value="<?php echo $interest; ?>" placeholder="Interest">
                                </div>
                                <div class="form-group">
                                    <button type="submit" name="update_account" class="btn btn-primary">Update Record</button>
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