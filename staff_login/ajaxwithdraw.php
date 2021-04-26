<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_GET['customeracid'];
$sql = "SELECT * FROM accounts 
INNER JOIN customers_master ON customers_master.c_id= accounts.c_id  WHERE accounts.account_no='$get_id' AND accounts.account_type!= '' AND accounts.account_status='Active'";
$stmt = $con->query($sql);
$rowcount = $stmt->rowCount();
if ($rowcount==0) {
    ?>
    <img src='image/LoadingSmall.gif' width='172' height='172'/>
    <?php
} else{
    while ($row = $stmt->fetch()) {
        $f_name = $row['f_name'];
        $l_name = $row['l_name'];
        $ifsccode = $row['ifsccode'];
        $account_no = $row['account_no'];
        $account_type = $row['account_type'];
        $account_balance = $row['account_balance'];
    }
    ?>
    <table class="table table-bordered table-striped">
        <tr>
            <th>IFSC code</th>
            <td><?php echo $ifsccode; ?></td>
        </tr>
        <tr>
            <th>Customer Name</th>
            <td><?php echo $f_name; ?> <?php echo $l_name; ?></td>
        </tr>
        <tr>
            <th>Account Number</th>
            <td><?php echo $account_no; ?></td>
        </tr>
        <tr>
            <th>Account Type</th>
            <td><?php echo $account_type; ?></td>
        </tr>
        <tr>
            <th>Account Balance</th>
            <td><?php echo $account_balance; ?></td>
        </tr>

    </table>
    <div class="form-group">
        <?php
            $q = "SELECT * FROM account_master WHERE account_type = '$account_type'";
            $stmt = $con->query($q);
            $rowdata = $stmt->fetch();
            $withdrawamount = $account_balance - $rowdata['min_balance'];

        ?>
        <label for="amt">You Can Withdraw upto</label>
        <input class="form-control" name="withdrawamount" readonly value="<?php echo $withdrawamount;?>">
    </div>
    <div class="form-group">
        <label for="amt">Amount</label>
        <input class="form-control" name="amount">
    </div>
    <div class="form-group">
        <label for="particulars">Particulars</label>
        <textarea class="form-control"  name="particulars" rows="5" col="25" placeholder="Particulars">
        </textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary"name="Withdraw_money" value="Withdraw Money"/>
    </div>
    <?php
}
?>