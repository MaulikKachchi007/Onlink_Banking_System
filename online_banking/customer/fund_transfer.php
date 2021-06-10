<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$c_id = $_SESSION['c_id'];
if (isset($_POST["submit"])) {
    $to_account_no = $_POST['account_number'];
    $regpayregistered_payee_type = $_POST['regpayregistered_payee_type'];
    $from_account_no = $_POST['regpaybank_acc_no'];
    $registered_payee_id = $_POST['registered_payee'];
    $approve_date_time = date('Y-m-d');
    $trans_date_time = date('Y-m-d');
    $amount = $_POST['amount'];
    $particular = $_POST['particular'];
    $transfer_upto =  $_POST['transfer_upto'];
    if (empty($amount) || empty($particular)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('registeredpayee.php');
    }else{
        global $con;
        if ($regpayregistered_payee_type == 'OctoPrime E-Banking') {
//            Transaction Debit
            $sql = "insert into transaction(registered_payee_id,from_account_no,to_account_no,amount,comission,particulars,transaction_type,trans_date_time,approve_date_time,payment_status)
            VALUES(:registered_payee_id,:from_account_no,:to_account_no,:amount,:comission,:particulars,:transaction_type,:trans_date_time,:approve_date_time,:payment_status)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':registered_payee_id', $registered_payee_id);
            $stmt->bindValue(':from_account_no', $from_account_no);
            $stmt->bindValue(':to_account_no',  $to_account_no);
            $stmt->bindValue(':amount', $amount);
            $stmt->bindValue(':comission', '0');
            $stmt->bindValue(':particulars', $particular);
            $stmt->bindValue(':transaction_type', 'Debit');
            $stmt->bindValue(':trans_date_time', $trans_date_time);
            $stmt->bindValue(':approve_date_time', $approve_date_time);
            $stmt->bindValue(':payment_status', 'Active');
            $result = $stmt->execute();
            $q = "Update accounts SET account_balance= account_balance - $amount WHERE account_no = '$to_account_no'";
            $stmt = $con->prepare($q);
            $result=$stmt->execute();

//            Transaction Update on Credit Account
            $sql = "insert into transaction(registered_payee_id,from_account_no,to_account_no,amount,comission,particulars,transaction_type,trans_date_time,approve_date_time,payment_status)
            VALUES(:registered_payee_id,:from_account_no,:to_account_no,:amount,:comission,:particulars,:transaction_type,:trans_date_time,:approve_date_time,:payment_status)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':registered_payee_id', $registered_payee_id);
            $stmt->bindValue(':from_account_no', $to_account_no);
            $stmt->bindValue(':to_account_no', $from_account_no);
            $stmt->bindValue(':amount', $amount);
            $stmt->bindValue(':comission', '0');
            $stmt->bindValue(':particulars', $particular);
            $stmt->bindValue(':transaction_type', 'Credit');
            $stmt->bindValue(':trans_date_time', $trans_date_time);
            $stmt->bindValue(':approve_date_time', $approve_date_time);
            $stmt->bindValue(':payment_status', 'Active');
            $result = $stmt->execute();
            $qr = "Update accounts SET account_balance= account_balance + $amount WHERE account_no = '$from_account_no'";
            $stmt = $con->prepare($qr);
            $result=$stmt->execute();
        }
        if ($regpayregistered_payee_type =='Other') {
            $amt = $amount + 5;
            $sql = "insert into transaction(registered_payee_id,from_account_no,to_account_no,amount,comission,particulars,transaction_type,trans_date_time,approve_date_time,payment_status)
            VALUES(:registered_payee_id,:from_account_no,:to_account_no,:amount,:comission,:particulars,:transaction_type,:trans_date_time,:approve_date_time,:payment_status)";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':registered_payee_id', $registered_payee_id);
            $stmt->bindValue(':from_account_no', $from_account_no);
            $stmt->bindValue(':to_account_no', $to_account_no);
            $stmt->bindValue(':amount', $amt);
            $stmt->bindValue(':comission', '5');
            $stmt->bindValue(':particulars', $particular);
            $stmt->bindValue(':transaction_type', 'Debit');
            $stmt->bindValue(':trans_date_time', $trans_date_time);
            $stmt->bindValue(':approve_date_time', $approve_date_time);
            $stmt->bindValue(':payment_status', 'Active');
            $result = $stmt->execute();
            $q = "Update accounts SET account_balance   = account_balance - $amt WHERE account_no = '$from_account_no'";
            $stmt = $con->prepare($q);
            $result = $stmt->execute();
        }
        if ($result) {
            $_SESSION['success_message'] = "Transaction completed successfully";
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
                                        <h1 class="text-dark">Fund Transfer</h1>
                                        <p class="text-muted">Enter Fund Transfer Detail</p>
                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                            <li class="breadcrumb-item active">Fund Transfer</li>
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
                                    <label for="account_number">Select Account Number</label>
                                    <select name="account_number" id="account_number" class="form-control" onChange="showcustomer(account_number.value)">
                                        <option value="Select" selected>Select Fund Transfer Type</option>
                                        <?php
                                            global $con;
                                            $sql = "SELECT * FROM accounts WHERE c_id='$c_id' and account_type='Saving Account' or account_type='Current Account'  AND account_status='Active'";
                                            $stmt = $con->query($sql);
                                            while ($row = $stmt->fetch()) {
                                                $account_no = $row['account_no'];
                                            ?>
                                        <option value="<?php echo $account_no;?>"><?php echo $account_no; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div id="loadcustdata">
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
<!--        Transaction Password Model-->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Verify your Transaction</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="divverifyform">
                <div id="divvalidate" style="color: red;font-size: 20px;"></div>
                <div class="form-group">
                    <label for="otp">Kindly Enter the OTP Which you received by Email</label>
                    <input type="text" class="form-control" autocomplete="off" name="otp" id="otp" placeholder="Enter OTP Here">
                    <div id="jsotpvalidation" style="color: red; font-size: 20px;"></div>
                </div>
                <div class="form-group">
                    <label for="transaction_password">Transaction Password</label>
                    <input type="password" class="form-control" autocomplete="off" name="transaction_password" id="tran_password" placeholder="Enter Transaction Password">
                    <div id="jspasswordvalidation" style="color: red; font-size: 20px;"></div>
                </div>
            </div>
            <div class="modal-footer" id="divverify">
                <button type="button" class="btn btn-primary" onclick="jsvalidation();otpverification();">Verify</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


</div>

<!--        End Transaction Password Model -->
<?php
include 'include/footer.php';
?>
<script type="text/javascript">
    function jsvalidation() {
        var otp = document.getElementById("otp").value;
        var password = document.getElementById("tran_password").value;
        if(otp == "") {
            document.getElementById('jsotpvalidation').innerHTML = "Otp is Fill in Required";
            return false;
        }
        // else {
        //     document.getElementById('jsotpvalidation').innerHTML ="";
        //     return true;
        // }
        if(password == "") {
            document.getElementById('jspasswordvalidation').innerHTML = "Password is Fill in Required";
            return false;
        }
            // else {
        //     document.getElementById('jspasswordvalidation').innerHTML = "";
        //     return true;
        // }
    }
    function otpverification(){
        // document.getElementById("divverify").innerHTML = "<img src='image/loadingverif.gif' height='50px;'>";
        if (window.XMLHttpRequest)
        {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        }
        else
        {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function()
        {
            if (this.readyState == 4 && this.status == 200)
            {
                //document.getElementById("txtHint").innerHTML = this.responseText;
                // alert(this.responseText);
                if(this.responseText != 1)
                {
                    // document.getElementById("divac").style.pointerEvents = "none";
                    // document.getElementById("idregpaye").style.pointerEvents = "none";
                    document.getElementById("amount").readOnly = true;
                    document.getElementById("particulars").readOnly = true;
                    document.getElementById("divverifyform").innerHTML = "<strong>You have verified successfully..</strong>";
                    document.getElementById("divverify").innerHTML =  '<button type="button" class="btn btn-success" data-dismiss="modal">Verify Successfully</button>';
                    document.getElementById("divbtnfundtransfer").innerHTML = '<button type="submit" class="btn btn-success" name="submit">Click Here to Transfer Fund</button>';
                }
                else
                {
                    document.getElementById("divverify").innerHTML = this.responseText;
                }
            }
        };
        var otp = document.getElementById("otp").value;
        var trpass = document.getElementById("tran_password").value;
        //alert(otp);
        //alert(trpass);
        xmlhttp.open("GET","verifytransaction.php?otp="+otp+"&trpass="+trpass,true);
        xmlhttp.send();
    }

    function verifytransaction()
    {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        //alert(document.getElementById("trpass"));
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                //document.getElementById("txtHint").innerHTML = this.responseText;
                //alert(this.responseText);
            }
        };
        xmlhttp.open("GET","verifytransaction.php",true);
        xmlhttp.send();
    }
    function verifytrans(){
        var amount = $('#amount').val();
        var withdrawalamt = $('#transfer_upto').val();
        if(amount<100 || amount>withdrawalamt){
            $('#jsamount').html('amount can not be less than 100 or greater than '+ withdrawalamt);
            $('#amount').val('');
        }else{
            $('#jsamount').html('');
            // jQuery.noConflict();
            $('#myModal').modal('show');
        }

    }
    function showcustomer(customeracid)
    {
        console.log(customeracid);
        document.getElementById("loadcustdata").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
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
                    document.getElementById("loadcustdata").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
                }
                else
                {
                    document.getElementById("loadcustdata").innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("GET","ajaxfundtranfer.php?customeracid="+customeracid,true);
        xmlhttp.send();
    }
    function showregpayee(registered_payee_id)
    {
        document.getElementById("divpayeedet").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";


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
                    document.getElementById("divpayeedet").innerHTML = "<img src='image/LoadingSmall.gif' width='172' height='172' />";
                }
                else
                {
                    document.getElementById("divpayeedet").innerHTML = this.responseText;
                }
            }
        };
        xmlhttp.open("GET","ajaxregpayeedetails.php?registered_payee_id="+registered_payee_id,true);
        xmlhttp.send();
    }
</script>