<?php
include 'include/DB.php';
include 'include/function.php';
global $con;
$loan_account_number = $_GET['loan_account_number'];
$sq = "SELECT * FROM loan_payment WHERE loan_account_number='$loan_account_number' ORDER BY payment_id desc LIMIT 1";
$st = $con->query($sq);
while ($row = $st->fetch()) {
    $_SESSION['tot_pay'] = $row['balance'];
}
$sql = "SELECT loan.loan_id,loan_type_master.prefix,customers_master.ifsccode,customers_master.l_name,customers_master.f_name,loan.loan_account_number,loan_type_master.terms,loan_type_master.loan_type,loan.intrest,loan.c_id,loan.created_date,loan_amount,loan_type_master.interest,loan.status from ((loan_type_master 
        INNER JOIN loan ON loan_type_master.id=loan.id)
        INNER JOIN customers_master ON customers_master.c_id=loan.c_id) where loan.loan_account_number='$loan_account_number' and loan.status='Approved'";
$stmt = $con->query($sql);
$result = $stmt->rowCount();
if ($result > 0)
{
while ($row = $stmt->fetch()) {
    $loan_id = $row['loan_id'];
    $loan_account_number = $row['loan_account_number'];
    $f_name = $row['f_name'];
    $l_type = $row['loan_type'];
    $ifsccode = $row['ifsccode'];
    $loan_amount  = $row['loan_amount'];
    $interest = $row['interest'];
    $intrest = $row['intrest'];
    $created_date = $row['created_date'];
    $total_payable = $loan_amount + $intrest;

    $term = $row['terms'];
    $status = $row['status'];
    $interest_paid_amt = $total_payable / ($term * 12);
    $_SESSION['paid_amt'] =$interest_paid_amt;
?>
<table class="table table-bordered table-striped">
    <tr>
        <th>Customer Name</th>
        <td><?php echo $row['f_name']; ?> <?php echo $row['l_name']; ?></td>
    </tr>
    <tr>
        <th>IFSC code</th>
        <td><?php echo $ifsccode; ?></td>
    </tr>
    <tr>
        <th>Loan Account Number</th>
        <td><?php echo $loan_account_number; ?></td>
    </tr>
    <tr>
        <th>Loan Type</th>
        <td><?php echo $l_type; ?> (<?php echo $row['prefix'];?>)</td>
    </tr>
    <tr>
        <th>Loan Amount</th>
        <td><?php echo $loan_amount; ?></td>
        <input type="hidden" name="loan_amount" id="loan_amount" value="<?php echo $loan_amount;?>">
    </tr>
    <tr>
        <th>Interest</th>
        <td><?php echo $interest; ?></td>
        <input type="hidden" name="interest" id="interest" value="<?php echo $interest;?>">
    </tr>
    <tr>
        <th>Interest Amount</th>
        <td><?php echo ($loan_amount * $interest) / 100; ?></td>
    </tr>
    <tr>
        <th>Total Payble Amount</th>
        <td><?php echo $total_payable = $loan_amount + ($loan_amount * $interest/100); ?></td>
        <input type="hidden" name="totamt" id="totamt" value="<?php echo $total_payable-$_SESSION['paid_amt'];?>">
    </tr>
    <tr>
        <th>Toatal Paid Amount</th>
        <td><?php echo $loan_amount; ?></td>
    </tr>
    <tr>
        <th>Balance</th>
        <td><?php echo $_SESSION['tot_pay']; ?>


        </td>
    </tr>
</table>
<?php
    }
}
?>

<?php
$get_id = $_SESSION['c_id'];
if(isset($get_id)) {
?>
     <div class="form-group">
    <select class="form-control" name="account" onChange="showcustomer(this.value)">
        <option value="Select" selected>Select</option>
        <?php
            $sql = "SELECT * FROM accounts INNER JOIN customers_master ON customers_master.c_id = accounts.c_id AND customers_master.c_id='$get_id' and accounts.account_status ='Active' and accounts.account_type ='Saving Account' OR accounts.account_type ='Current Account' ";
            $stmt = $con->query($sql);
            while ($row = $stmt->fetch()) {
                $account_no = $row['account_no'];
        ?>
                <option value="<?php echo $account_no;?>"><?php echo $account_no;?></option>
        <?php
            }
        ?>
    </select>
     </div>
    <div id="show_customer_record"></div>
<?php
}
?>