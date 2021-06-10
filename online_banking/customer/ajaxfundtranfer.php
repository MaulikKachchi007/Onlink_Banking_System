<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_GET['customeracid'];
$sql = "SELECT * FROM accounts INNER JOIN customers_master ON customers_master.c_id=accounts.c_id WHERE accounts.account_no='$get_id'  and accounts.account_status='Active'";
$stmt = $con->query($sql);
$rc = $stmt->rowCount();
if ($rc==0) {
    ?>
    <img src='image/LoadingSmall.gif' width='172' height='172' />
<?php
}else{
    ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th>IFSC Code</th>
            <th>Name</th>
            <th>Login</th>
            <th>Address</th>
        </tr>
        <?php

        while($row = $stmt->fetch()) {
            $ifsccode = $row['ifsccode'];
            $account_no = $row['account_no'];
            $account_type = $row['account_type'];
            $account_balance = $row['account_balance'];
            $unclear_balance = $row['unclear_balance'];
            $f_name = $row['f_name'];
            $email = $row['email'];
            $locality = $row['locality'];
            $city = $row['city'];
        ?>
        <tr>
            <td><?php echo $ifsccode; ?></td>
            <td><?php echo  $f_name; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $locality; ?> <?php echo $city; ?></td>
        </tr>
    </table>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Account Number</th>
            <th>Account Type</th>
            <th>Account Balance</th>
            <th>Unclear Balance</th>
        </tr>
        <?php

            ?>
            <tr>
                <td><?php echo $account_no; ?></td>
                <td><?php echo  $account_type; ?></td>
                <td><?php echo $account_balance; ?></td>
                <td><?php echo $unclear_balance; ?></td>
            </tr>
    </table>
            <?php
        }
    ?>
<?php
        }
?>
<hr>
<h2>Transfer Funds To</h2>
<div class="form-group">
    <label for="Registered_Payee">Registered Payee</label>
    <select name="registered_payee" id="registered_payee" class="form-control" onChange="showregpayee(this.value)">
        <option value="Select" selected>Select Fund Transfer Type</option>
        <?php
            $g_id = $_SESSION['c_id'];
            $q = "SELECT * FROM `registered_payee` WHERE c_id='$g_id'";
            $stmt = $con->query($q);
            while ($row = $stmt->fetch()) {
                $registered_payee_id  = $row['registered_payee_id'];
                $payee_name  = $row['payee_name'];
                $account_no  = $row['account_no'];
                $ifsc_code = $row['ifsccode'];
                $bank_name = $row['bank_name'];
        ?>
        <option value="<?php echo $registered_payee_id;?>"><?php echo $payee_name;?> | <?php echo $account_no;?> | <?php echo $bank_name; ?> | <?php echo $ifsc_code;?></option>
        <?php }?>
    </select>
</div>
<div class="form-group">
    <div id="divpayeedet">
    </div>
</div>
<div class="form-group">
    <?php
        $sql = "SELECT * FROM  accounts INNER JOIN account_master ON account_master.account_type=accounts.account_type WHERE accounts.account_no='$get_id'";
        $stmt = $con->query($sql);
        $rd = $stmt->fetch();
        $withdrawamount = $rd['account_balance']  - $rd['min_balance'];
    ?>
    <label for="transfer_upto">You Can Transfer Upto</label>
   <input class="form-control" name="transfer_upto" id="transfer_upto" readonly value="<?php echo $withdrawamount; ?>" placeholder="You can transfer Upto" type="text" >
</div>
<div class="form-group">
    <label for="amount">Amount</label>
    <input class="form-control" name="amount" id="amount" placeholder="Enter a Amount" type="text" >
    <span id="jsamount" style="color: #ff0000;font-size: 20px;"></span>
</div>
<div class="form-group">
    <label for="particular">Particulars</label>
    <textarea class="form-control" name="particular" id="particulars" rows="5" cols="20" placeholder="Enter a Particular"></textarea>
</div>
<div class="form-group" id="divbtnfundtransfer">
    <input type='button' class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"  id="btnverify" onclick="verifytrans();verifytransaction();" name="transfer_fund"  value="Transfer Funds">
</div>
<!--<script type="text/javascript">-->
<!--    -->
<!--</script>-->