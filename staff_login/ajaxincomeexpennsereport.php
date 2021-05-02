<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['id'];
$fromDate = $_GET['fromdate'];
$toDate = $_GET['todate'];
global $con;
$sql = "SELECT * FROM employees_master where id='$get_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()){
    $ifsccode = $row['ifsccode'];
}
?>
<?php
    $sql = "SELECT * FROM transaction WHERE trans_date_time='$fromDate' and trans_date_time='$toDate'";
    $stmt = $con->query($sql);
    while ($row = $stmt->fetch()) {
            
    }


?>
<table class="table table-bordered table-striped">
    <tr>
        <thead>
            <th colspan="3" style="text-align:center">Deposite</th>
            <th colspan="3" style="text-align:center">Withdraw</th>
        </thead>
    </tr>
        <tr>
            <th>Date</th>

            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>

            <th>Type</th>
            <th>Amount</th>
        </tr>
        <tbody>

        </tbody>
    <tfoot>
        <tr>
            <td colspan="1"></td>
            <td><b><h3>Total</h3></b></td>
            <td><b><h3><?php echo 0; ?></h3></b></td>
            <td colspan="1"></td>
            <td><b><h3>Total</h3></b></td>
            <td><b><h3><?php echo 0; ?></h3></b></td>
        </tr>
    </tfoot>
</table>
