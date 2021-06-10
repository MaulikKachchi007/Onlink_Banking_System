<?php
include 'include/DB.php';
include 'include/function.php';
//include 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_SESSION['c_id'];
$lastid='';
global $con;
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
if (isset($_POST["add_fd_account"])) {
    $acc_number = $_POST['account_no'];
    $min_amt = $_POST['min_amt'];
    $max_amt = $_POST['max_amt'];
    $get_id = $_SESSION['c_id'];
    $fd_type = $_POST['fd_type'];
    $fd_amount = $_POST['inv_amt'];
    $fd_date =  date('Y-m-d');
    $trans_date_time = date('Y-m-d');
    $interest = $_POST['interest'];
    $status = "Active";
    if (empty($fd_amount)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('add_fd_account.php');
    }elseif($min_amt > $fd_amount){
        $_SESSION["error_message"] = "Fixed Deposite must be greater than {$min_amt}.";
        redirect('add_fd_account.php');
    }elseif ($max_amt < $fd_amount){
        $_SESSION["error_message"] = "Fixed Deposite must be Less than {$max_amt}.";
        redirect('add_fd_account.php');
    }else {
        global $con;
        $sql = "INSERT INTO accounts(account_no,c_id,f_id,account_type,account_balance,account_open_date,interest,account_status)
                VALUES(:account_no,:c_id,:f_id,:account_type,:account_balance,:account_open_date,:interest,:account_status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':account_no',$acc_number);
        $stmt->bindValue(':c_id',$get_id);
        $stmt->bindValue(':f_id',$fd_type);
        $stmt->bindValue(':account_type','Fixed Deposite Account');
        $stmt->bindValue(':account_balance',$fd_amount);
        $stmt->bindValue(':account_open_date',$fd_date);
        $stmt->bindValue(':interest',$interest);
        $stmt->bindValue(':account_status',$status);
        $result = $stmt->execute();
//        Transaction From decute from after creating fd account
        $qr = "SELECT * FROM accounts WHERE c_id='$get_id' and account_type='Saving Account' or account_type='Current Account'";
        $stmt = $con->query($qr);
        while ($row = $stmt->fetch()){
            $ac_no = $row['account_no'];
        }
//        $q = "INSERT INTO transaction (from_account_no,to_account_no,amount,comission,particulars,transaction_type,approve_date_time,payment_status)
//              VALUES ('$ac_no','$accounts_no','$fd_amount','0','To The Invesment Fixed Deposite Account','Debit','$fd_date','Active')";
//        echo $q;
        $q = "INSERT INTO transaction (from_account_no,to_account_no,amount,comission,particulars,transaction_type,trans_date_time,approve_date_time,payment_status)
              VALUES (:from_account_no,:to_account_no,:amount,:comission,:particulars,:transaction_type,:trans_date_time,:approve_date_time,:payment_status)";
        $st = $con->prepare($q);
        $st->bindValue(':from_account_no',$acc_number);
        $st->bindValue(':to_account_no',$ac_no);
        $st->bindValue(':amount',$fd_amount);
        $st->bindValue(':comission','0');
        $st->bindValue(':particulars','To The Invesment Fixed Deposite Account');
        $st->bindValue(':transaction_type','Debit');
        $st->bindValue(':trans_date_time', $trans_date_time);
        $st->bindValue(':approve_date_time', $fd_date);
        $st->bindValue(':payment_status','Active');
        $result = $st->execute();
        $uq = "UPDATE accounts SET account_balance= account_balance-$fd_amount WHERE account_no='$ac_no' and account_type='Saving Account' or account_type='Current Account'";
        $stm = $con->prepare($uq);
        $result = $stm->execute();
        if ($result) {
            $_SESSION['success_message'] = "Fixed Deposite Account Successfully";
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
                                            <h1 class="text-dark">Add FD Account</h1>
                                            <p class="text-muted">Enter FD Account Details</p>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add FD Account</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_fd_account.php" class="btn btn-info float-right text-white">View Record</a>
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
                                        <label for="account_no">Account Number</label>
                                        <input class="form-control" style="color: red;" value="<?php echo $accounts_no; ?>" name="account_no" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="fd_type">Fixed Deposite Account Type</label>
                                        <select name="fd_type" class="form-control" onchange="loadfdaccountrec(this.value)">
                                            <option value="Select" selected>Select</option>
                                            <?php
                                            global $con;
                                            $q = "SELECT * FROM fixed_deposite WHERE status='active'";
                                            $stmt = $con->query($q);
                                            while ($row = $stmt->fetch()){
                                                $fid = $row['f_id'];
                                                $d_type = $row['d_type'];
                                                ?>
                                                <option value="<?php echo $fid;?>"><?php echo $d_type;?></option>
                                                <?php
                                            }
                                            ?>

                                       </select>
                                    </div>

                                    <div id="fdaccountloading"><img src="image/LoadingSmall.gif" width="172" height="172" /></div>

                                    <!-- /.card-body -->
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        function loadfdaccountrec(id) {
            if(window.XMLHttpRequest){
                xmlhttp = new XMLHttpRequest();
            }else{
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function(){
                if (this.readyState == 4 && this.status==200){
                    document.getElementById('fdaccountloading').innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","ajaxfdaccount.php?id="+id,true);
            xmlhttp.send();
        }
        function calculategrandtotal()
        {
            //alert(d   ocument.getElementById("amtloanamount").value);
            document.getElementById("total_profit").value = parseFloat(document.getElementById("inv_amt").value) * parseFloat(document.getElementById("interest").value) /100;
            // )/100;
            document.getElementById("grandtotal").value = parseFloat(document.getElementById("inv_amt").value) * parseFloat(document.getElementById("interest").value) /100 + parseFloat(document.getElementById("inv_amt").value);

        }
    </script>
<?php
include 'include/footer.php';
?>