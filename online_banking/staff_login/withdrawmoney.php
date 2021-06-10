<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$q = "SELECT * FROM accounts";
$stmt = $con->query($q);
while($row = $stmt->fetch()){
    $c_id = $row['c_id'];
}
if (isset($_POST["Withdraw_money"])) {
    $acc_no = $_POST["acc_no"];
    $amount = $_POST["amount"];
    $withdrawamount = $_POST["withdrawamount"];
    $particulars = $_POST["particulars"];
    $approve_date_time = date("Y-m-d");
    $trans_date_time =date("Y-m-d");
    if (empty($amount)  || empty($particulars)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('withdrawmoney.php');
    } elseif($withdrawamount <= 0){
        $_SESSION["error_message"] = "Insufficient Balance.";
        redirect('withdrawmoney.php');
    } else{
        global $con;
        $sql = "insert into transaction(to_account_no,amount,comission,particulars,transaction_type,trans_date_time,approve_date_time,payment_status) 
            VALUES(:to_acc_no,:amount,:comission,:particulars,:transaction_type,:trans_date_time,:approve_date_time,:payment_status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':to_acc_no', $acc_no);
        $stmt->bindValue(':amount', $amount);
        $stmt->bindValue(':comission', '0');
        $stmt->bindValue(':particulars', $particulars);
        $stmt->bindValue(':transaction_type', 'Debit');
        $stmt->bindValue(':trans_date_time', $trans_date_time);
        $stmt->bindValue(':approve_date_time', $approve_date_time);
        $stmt->bindValue(':payment_status', 'Active');
        $result = $stmt->execute();
        $q = "UPDATE accounts SET account_balance= account_balance -   $amount  WHERE account_no='$acc_no'";
        $st = $con->query($q);
        if ($result) {
            $_SESSION['success_message'] = "Withdraw Transaction Successfully";
        } else {
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
                                            <h1 class="text-dark">Withdraw Money</h1>
                                            <p class="text-muted">Enter transaction Detail</p>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Withdraw Money</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
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
                                        <label for="acc_no">Account Number</label>
                                        <input class="form-control" placeholder="Account Number" name="acc_no"  onKeyUp="showcustomer(this.value)">
                                    </div>
                                    <div id="divcustrecloadid">
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
    <script type="text/javascript">
        function showcustomer(customeracid)
        {
            document.getElementById("divcustrecloadid").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText == 0)
                    {
                        document.getElementById("divcustrecloadid").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
                    }
                    else
                    {
                        document.getElementById("divcustrecloadid").innerHTML = this.responseText;
                    }
                }
            };
            xmlhttp.open("GET","ajaxwithdraw.php?customeracid="+customeracid,true);
            xmlhttp.send();
        }
</script>