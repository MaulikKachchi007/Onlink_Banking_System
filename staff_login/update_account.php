<?php
include 'include/DB.php';
include 'include/function.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST["update_account"])) {
    $get_id = $_GET['id'];
    $a_type = $_POST["accounttype"];
    $ac_no = $_POST["account_no"];
    $balance = $_POST["account_balance"];
    $interest = $_POST["interest"];
    if (empty($a_type) || empty($balance) || empty($interest)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
        $q = "Update accounts SET account_type='$a_type',account_balance='$balance',interest='$interest' WHERE c_id='$get_id'";
        $stmt = $con->prepare($q);
        $result = $stmt->execute();
        var_dump($result);
        if ($result) {
            $_SESSION['success_message'] = "Customer Details Update Successfully";
            redirect('view_bank_account.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
            redirect('view_bank_account.php');
        }
    }
}
global $con;
$firstname = $lastname = $email = $photo = $phone = $houseno = $locality = $area = $pincode = $city = $gender = $date = $adharnumber = $marital = $occuption = $account_type = $password = $cpwd =$pin = $cpin =  "";
$sql = "SELECT * from accounts WHERE c_id ='$get_id'";
$stmt = $con->query($sql);
$result = $stmt->execute();
while ($row = $stmt->fetch()) {
    $account_type = $row['account_type'];
    $ac_no = $row["account_no"];
    $balance = $row["account_balance"];
    $interest = $row["interest"];
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
                                            <li class="breadcrumb-item"><a href="bankinguser/index.php">Home</a></li>
                                            <li class="breadcrumb-item active">Update Account</li>
                                        </ol>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div>
                            <a href="view_customers.php" class="btn btn-info float-right text-white">View Record</a>
                        </div>
                        <div class="container p-1">
                            <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            ?>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="update_account.php?id=<?php echo $get_id; ?>" method="post">

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="account_no">Account Number</label>
                                    <input class="form-control" readonly name="account_no" value="<?php echo $ac_no;?>" style="color:red;" placeholder="Account Number">
                                </div>
                                <div class="form-group">
                                    <label for="accounttype">Account Type</label>
                                    <select name="accounttype" class="form-control">
                                        <option value="<?php echo $account_type;?>"><?php echo $account_type;?></option>
                                        <?php
                                        $sql = "SELECT * FROM account_master";
                                        $stmt = $con->prepare($sql);
                                        $stmt->execute();
                                        while ($row = $stmt->fetch()) {
                                            $account_type = $row['account_type'];
                                            echo "<option value='$account_type'>$account_type</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="interest">Interest</label>
                                    <?php
                                    $qr = "SELECT * FROM account_master WHERE account_type='$account_type'";
                                    $stmt = $con->query($qr);
                                    while ($row = $stmt->fetch()){
                                        $sinterest = $row['interest'];
                                    }
                                    ?>
                                    <input class="form-control" name="interest"  value="<?php echo $sinterest; ?>"placeholder="Interest">
                                </div>
                                <div class="form-group">
                                    <label for="account_balance">Account Balance</label>
                                    <input class="form-control" name="account_balance" value="<?php echo $balance; ?>" placeholder="Account Balance">
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
<script>

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
</script>
