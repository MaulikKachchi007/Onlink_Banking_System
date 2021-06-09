<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_GET['loanaccid'];
$sql = "SELECT * FROM loan 
        INNER JOIN loan_type_master ON loan_type_master.id= loan.id  
        WHERE loan.loan_account_number='$get_id' AND loan.status='Approved'";
$stmt = $con->query($sql);
while ($rowdata = $stmt->fetch()) {
    $c_id = $rowdata['c_id'];
    $loan_account_number = $rowdata['loan_account_number'];
    $loan_type = $rowdata['loan_type'];
    $loan_amount = $rowdata['loan_amount'];
    $interest = $rowdata['interest'];
}
$rowcount = $stmt->rowCount();
if ($rowcount==0) {
    ?>
    <img src='image/LoadingSmall.gif' width='172' height='172'/>
    <?php
} else{
    $sqlloan ="SELECT sum(paid) FROM loan_payment WHERE loan_account_number='$get_id'";
    $stmt = $con->query($sqlloan);
    $row_data = $stmt->fetch();
    $sql = "SELECT * FROM customers_master INNER JOIN loan  ON customers_master.c_id=loan.c_id 
            INNER JOIN accounts ON accounts.c_id= customers_master.c_id
            WHERE loan.c_id='$c_id' and loan.status='Approved' and accounts.account_type='Saving Account' or accounts.account_type= 'Current Account';";
    $stmt = $con->query($sql);
    while ($row = $stmt->fetch()) {
        $f_name = $row['f_name'];
        $l_name = $row['l_name'];
        $ifsccode = $row['ifsccode'];
        $account_no = $row['account_no'];
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
            <th>Loan Account Number</th>
            <td><?php echo $loan_account_number; ?></td>
        </tr>
        <tr>
            <th>Loan Type</th>
            <td><?php echo $loan_type; ?></td>
        </tr>
        <tr>
            <th>Loan Amount</th>
            <td>Rs. <?php echo $loan_amount; ?></td>
        </tr>
        <tr>
            <th>Interest</th>
            <td><?php echo $interest; ?>%</td>
        </tr>
        <tr>
            <th>Interest Amount</th>
            <td><?php echo ($loan_amount * $interest) /100; ?>%</td>
        </tr>
        <tr>
            <th>Total Payble Amount</th>
            <td><?php echo $total_payable = $loan_amount + ($loan_amount * $interest) /100; ?></td>
        </tr>
        <tr>
            <th>Total Paid Amount</th>
            <td><?php echo $row_data[0]; ?></td>
        </tr>
        <tr>
            <th>Balance Amount</th>
            <td><?php echo $balamt = $total_payable - $row_data[0]; ?></td>
        </tr>
    </table>
    <input type="hidden" name="custid" value="<?php echo $c_id; ?>" >
    <input type="hidden" name="loan_amt" value="<?php echo $loan_amount; ?>" >
    <input type="hidden" name="interest" value="<?php echo $interest; ?>" >
    <input type="hidden" name="account_no" value="<?php echo $account_no; ?>" >
    <?php if (isset($_SESSION['id'])){
        ?>
    <div class="form-group">
        <label for="amt">Paid Amount</label>
        <input class="form-control" type="text" name="paidamt" readonly id="paidamt" value="<?php echo $loan_amount;?>" placeholder="Paid Amount">
    </div>
        <div class="form-group">
            <label for="particulars">Particulars</label>
            <textarea class="form-control"  name="particulars" rows="5" col="25" placeholder="Particulars">
        </textarea>
        </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="make_payment" value="Transfer Money"/>
    </div>
    <?php
}
}
?>