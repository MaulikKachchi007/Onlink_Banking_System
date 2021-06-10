<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_GET['registered_payee_id'];
$sql = "SELECT * FROM registered_payee WHERE registered_payee_id ='$get_id'";
$stmt = $con->query($sql);
$rc = $stmt->rowCount();
if ($rc==0) {
    ?>
    <img src='image/LoadingSmall.gif' width='172' height='172' />
    <?php
}else{
?>
<table class="table table-bordered table-striped">
    <?php
    while($row = $stmt->fetch()) {
    $ifsccode = $row['ifsccode'];
    $account_no = $row['account_no'];
    $account_type = $row['account_type'];
    $bank_name = $row['bank_name'];
    $registered_payee_type = $row['registered_payee_type'];
    $payee_name = $row['payee_name'];
        ?>
    <tr>
        <th>Banking Account Type</th>
        <td><?php echo $registered_payee_type; ?>
            <input type="hidden" name="regpayregistered_payee_type" value="<?php echo $registered_payee_type; ?>">
        </td>
    </tr>
    <tr>
        <th>Payee Name</th>
        <td><?php echo $payee_name; ?>
            <input type="hidden" name="regpaypayee_name" value="<?php echo $payee_name; ?>"></td>
        </td>
    </tr>
    <tr>
        <th>Bank Account Number</th>
        <td><?php echo $account_no; ?></td>
        <input type="hidden" name="regpaybank_acc_no" value="<?php echo $account_no; ?>"></td>
    </tr>
    <tr>
        <th>Account type</th>
        <td><?php echo $account_type; ?>
            <input type="hidden" name="regpayacc_type" value="<?php echo $account_type; ?>">
        </td>
    </tr>
    <tr>
        <th>Bank Name</th>
        <td><?php echo $bank_name; ?>
            <input type="hidden" name="regpaybank_name" value="<?php echo $bank_name; ?>">
        </td>
        </td>
    </tr>
    <tr>
        <th>IFSC Code</th>
        <td><?php echo $ifsccode; ?>
            <input type="hidden" name="regpayifsc_code" value="<?php echo $ifsccode; ?>"></td>
        </td>
    </tr>
</table>
<?php
}
}
?>