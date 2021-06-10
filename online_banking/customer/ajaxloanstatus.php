<?php
include 'include/DB.php';
include 'include/function.php';
//include 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
    global $con;
    $loan_app_number = $_POST['loan_app_number'];
    $sql = "SELECT * FROM loan_type_master INNER JOIN loan  ON loan_type_master.id=loan.id  and loan.loan_account_number='$loan_app_number'";
    $stmt = $con->query($sql);
?>
<table class="table table-striped table-responsive">
    <thead>
    <tr>
        <th>Loan Account Number</th>
        <th>Loan Type</th>
        <th>Loan Amount</th>
        <th>Interest</th>
        <th>Date</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($stmt->rowCount() > 0) {
        while($row = $stmt->fetch())
        {
            $status = $row['status'];
        ?>

        <tr>
            <td><?php echo $row['loan_account_number'];?></td>
            <td><?php echo $row['loan_type'];?></td>
            <td><?php echo $row['loan_amount'];?></td>
            <td><?php echo $row['interest'];?></td>
            <td><?php echo $row['created_date'];?></td>
            <td><?php
                    if ($status == "Pending") {
                        echo "<div class='badge badge-warning'>$status</div>";
                    }elseif ($status == "Denied"){
                        echo "<div class='badge badge-danger'>$status</div>";
                    }elseif ($status == "Approved"){
                        echo "<div class='badge badge-success'>$status</div>";
                    }
                ?>
            </td>
        </tr>
    <?php }
    }else{ ?>
        <tr>
            <td colspan="6" class="text-bold text-center">No Data Found!</td>
    </tr>
    <?php }

    ?>
    </tbody>
</table>

