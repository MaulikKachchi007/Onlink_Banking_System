<?php
include 'include/DB.php';
include 'include/function.php';
global $con;
$sql = "SELECT loan.loan_id,customers_master.l_name,customers_master.f_name,loan.loan_account_number,loan_type_master.loan_type,loan.c_id,loan.created_date,loan_amount,loan.intrest,loan.status from ((loan_type_master 
                                    INNER JOIN loan ON loan_type_master.id=loan.id)
                                    INNER JOIN customers_master ON customers_master.c_id=loan.c_id)";
$stmt = $con->query($sql);
$result = $stmt->rowcount();
if ($result > 0)
{
while ($row = $stmt->fetch()) {
    $loan_id = $row['loan_id'];
    $loan_account_number = $row['loan_account_number'];
    $f_name = $row['f_name'];
    $l_type = $row['loan_type'];
    $loan_amount  = $row['loan_amount'];
    $interest = $row['intrest'];
    $created_date = $row['created_date'];
    $total_payable = $loan_amount + $interest;
    $status = $row['status'];
?>
<table class="table table-bordered table-striped">
    <tr>
        <th>Customer Name</th>
        <td><?php echo $row['f_name']; ?> <?php echo $row['l_name']; ?></td>
    </tr>
    <tr>
        <th>Loan Account Number</th>
        <td><?php echo $loan_account_number; ?></td>
    </tr>
    <tr>
        <th>Loan Type</th>
        <td><?php echo $l_type; ?></td>
    </tr>
    <tr>
        <th>Created Date</th>
        <td><?php echo $created_date; ?></td>
    </tr>
    <tr>
        <th>Loan Amount</th>
        <td><?php echo $loan_amount; ?></td>
    </tr>
    <tr>
        <th>Interest Amount</th>
        <td><?php echo $interest; ?></td>
    </tr>
    <tr>
        <th>Total Payble</th>
        <td><?php echo $total_payable; ?></td>
    </tr>

    <tr>
        <th>Status</th>
        <td>
            <form method="post" action="view_loan_pending.php?id=<?php echo $row['loan_id']; ?>">
                <select name="loanstatus" class="form-control">
                    <option value="Select" selected>Select</option>
                    <option value="Approved">Approved</option>
                    <option value="Pending">Pending</option>
                    <option value="Denied">Denied</option>
                </select>
        </td>
    </tr>
</table>
<?php
    }
}
?>