<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_GET['customeracid'];

$sql = "SELECT * FROM accounts INNER JOIN customers_master ON customers_master.c_id = accounts.c_id WHERE accounts.c_id='$get_id' AND accounts.account_type != '' AND accounts.account_status='Active'";
$stmt = $con->query($sql);
$rcount = $stmt->rowCount();
if($rcount != 0){
    ?>
    <img src='image/LoadingSmall.gif' width='172' height='172' /></div>
    <?php
}else{
    ?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>IFSC Code</th>
            <th>Name</th>
            <th>Account Number</th>
            <th>Account Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $get_id = $_GET['customeracid'];
            $sql= "SELECT * FROM accounts INNER JOIN customers_master ON customers_master.c_id = accounts.c_id WHERE accounts.account_no ='$get_id'";
            $st = $con->query($sql);
            while($row = $st->fetch()){
                $account_type = $row['account_type'];
                $ifsccode = $row['ifsccode'];
                $f_name = $row['f_name'];
                $l_name = $row['l_name'];
                $account_no = $row['account_no'];
            ?>
            <tr>
                <td><?php echo $ifsccode; ?></td>
                <td><?php echo $f_name; ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo  $account_type; ?></td>
            </tr>
            <input type="hidden" class="form-control" name="payeename" required="required" placeholder="Payee Name" value="<?php echo $f_name . " ".$l_name; ?>">
            <input type="hidden" class="form-control" name="bank_account_number" required="required" placeholder="Account Number" value="<?php echo $account_no; ?>">
            <input type="hidden" class="form-control" name="accounttype" required="required" placeholder="Account type" value="<?php echo $account_type; ?>">
            <input type="hidden" class="form-control" name="bankname" required="required" placeholder="Bank Name" value="OctoPrime E-Banking">
            <input type="hidden" class="form-control" name="ifsccode" required="required" placeholder="IFSC code"  value="<?php echo $ifsccode; ?>">
            <?php
        }
        ?>
        </tbody>
    </table>
<?php
}
?>