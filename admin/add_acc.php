<?php
include 'include/DB.php';
include 'include/function.php';
//include 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$lastid='';
global $con;
$get_id = $_GET['id'];
$q = "SELECT * FROM accounts order by account_no desc limit  1";
$stmt = $con->query($q);
while ($row = $stmt->fetch()) {
    $lastid = $row[0];
}
if ($lastid == "") {
    $accounts_no = "OPB0731010001";
}else {
    $accounts_no = substr($lastid,11);
    $accounts_no = intval($accounts_no);
    $accounts_no = "OPB073101000".($accounts_no + 1);
}
if (isset($_POST["add_account"])) {
    $a_type = $_POST["account_type"];
    $ac_no = $_POST["account_no"];
    $balance = $_POST["account_balance"];
    $interest = $_POST["interest"];
    $status = $_POST["account_status"];
    $date = date("Y-m-d");

    if (empty($a_type) || empty($balance) || empty($interest) || empty($status)) {
        $_SESSION["error_message"] = "All must fill required.";
    }elseif ($status == "Select") {
        $_SESSION["error_message"] = "At least one input selected";
    }else {
        global $con;
        $sql = "INSERT INTO accounts (account_no,c_id,account_type,account_balance,account_open_date,interest,account_status)  VALUES (:account_no,:c_id,:account_type,:account_balance,:account_open_date,:interest,:account_status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':account_no',$ac_no);
        $stmt->bindValue(':c_id',$get_id);
        $stmt->bindValue(':account_type',$a_type);
        $stmt->bindValue(':account_balance',$balance);
        $stmt->bindValue(':account_open_date',$date);
        $stmt->bindValue(':interest',$interest);
        $stmt->bindValue(':account_status',$status);
        $result = $stmt->execute();
//        Add Clear Balance
        $ac_no = $_POST["account_no"];
        date_default_timezone_set('asia/Calcutta');
        $approve_date_time = date('Y-m-d');
        $trans_date_time = date('Y-m-d');
        $iq = "INSERT INTO transaction(to_account_no,amount,comission, particulars,transaction_type,trans_date_time, approve_date_time, payment_status)
               VALUES(:to_account_no,:amount,:comission, :particulars,:transaction_type,:trans_date_time, :approve_date_time, :payment_status)";
        $st = $con->prepare($iq);
        $st->bindValue(':to_account_no',$ac_no);
        $st->bindValue(':amount',$balance);
        $st->bindValue(':comission',0);
        $st->bindValue(':particulars','Account opening balance');
        $st->bindValue(':transaction_type','Credit');
        $st->bindValue(':trans_date_time', $trans_date_time);
        $st->bindValue(':approve_date_time',$approve_date_time);
        $st->bindValue(':payment_status','Approved');
        $res = $st->execute();
        if ($result and $res) {
            $_SESSION['success_message'] = "Account Added Successfully";
            redirect('view_customers.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
            redirect('view_customers.php');
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
                                <a href="view_customers.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <!-- /.card-header -->
                            <?php  $get_id= $_GET["id"];?>
                            <!-- form start -->
                            <div class="card-body">
                                <form role="form" action="add_acc.php?id=<?php echo $get_id; ?>" method="post">
                                    <div class="form-group">
                                        <label for="account_no">Account Number</label>
                                        <input class="form-control" readonly name="account_no" value="<?php echo $accounts_no;?>" style="color:red;" placeholder="Account Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="account_type">Account Type</label>
                                        <?php
                                        global $con;
                                        $get_id= $_GET["id"];
                                        $qr = "SELECT * FROM customers_master WHERE c_id='$get_id'";
                                        $stmt = $con->query($qr);
                                        while ($row = $stmt->fetch()){
                                            $account_type = $row['account_type'];
                                        }
                                        ?>
                                        <input class="form-control" readonly name="account_type" value="<?php echo $account_type;?>"  placeholder="Account Type">
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
                                        <input class="form-control" name="interest" readonly value="<?php echo $sinterest; ?>"placeholder="Interest">
                                    </div>
                                    <div class="form-group">
                                        <label for="account_balance">Account Balance</label>
                                        <input class="form-control" name="account_balance"  placeholder="Account Balance">
                                    </div>
                                    <div class="form-group">
                                        <label for="account_balance">Account Status</label>
                                        <select class="form-control" name="account_status">
                                            <option value="Select">Select</option>
                                            <option value="Active">Active</option>
                                            <option value="Deactive">Deactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="add_account" class="btn btn-primary">Add Accounts</button>
                                    </div>
                                    <!-- /.card-body -->
                                </form>
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
<?php
