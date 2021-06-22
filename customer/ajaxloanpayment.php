<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
global $con;

$account_number = $_GET['account_number'];
$sql = "SELECT * FROM accounts INNER JOIN customers_master ON customers_master.c_id = accounts.c_id
        WHERE accounts.account_no ='$account_number' and accounts.account_status ='Active' and accounts.account_type ='Saving Account' OR accounts.account_type ='Current Account'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $ifsccode = $row['ifsccode'];
    $f_name = $row['f_name'];
    $account_no = $row['account_no'];
    $address = $row['locality'];
    $balance = $row['account_balance'];
    $account_type = $row['account_type'];
?>
    <table class="table table-bordered table-striped">
    <tr>
        <th>IFSC code</th>
        <th>Account Number</th>
        <th>Customer Name</th>
        <th>Address</th>
        <th>Account Type</th>
        <th>Account Balance</th>

    </tr>
    <tr>
        <td><?php echo $ifsccode; ?></td>
        <td><?php echo $account_no; ?></td>
        <td><?php echo $row['f_name']; ?> <?php echo $row['l_name']; ?>
        <td><?php echo $address; ?></td>
        <td><?php echo $account_type; ?></td>
        <td><?php echo $balance; ?></td>
    </table>
<hr>
    <?php
        global $con;
        $q= "SELECT * FROM account_master WHERE account_type='$account_type'";
        $stmt = $con->query($q);
        while ($rowdata = $stmt->fetch()) {
            $min_balance = $rowdata['min_balance'];
        }
    ?>
    <h2>Enter Loan Payment Detail</h2>
    <div class="form-group">
        <label for="pay_upto">You Can Pay upto</label>
        <input type="text" class="form-control" name="withdrawamt" readonly placeholder="Amount" value="<?php echo $balance - $min_balance; ?>"/>
    </div>
    <div class="form-group">
        <label for="paid_amt">Paid Amounnt</label>
        <input type="text" class="form-control"  autocomplete="off" readonly name="paid_amt" id="paid_amt" value="<?php echo $_SESSION['paid_amt'];?>"  placeholder="Paid Amount" />
    </div>
    <div class="form-group">
        <label for="bal_amt">Balance Amounnt</label>
            <input type="text" class="form-control" value="<?php echo $_SESSION['tot_pay']-$_SESSION['paid_amt']; ?>" name="bal_amt" id="balanceamt"  placeholder="Balance Amount"/>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="submit"  value="Make Payment"/>
    </div>

    <?php
}
?>