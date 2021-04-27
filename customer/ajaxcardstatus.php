<?php
include 'include/DB.php';
include 'include/function.php';
//include 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$card_app_number = $_POST['card_app_number'];
$sql = "SELECT * FROM card_type_master INNER JOIN cards  ON card_type_master.id=cards.id  and cards.card_application_number='$card_app_number'";
$stmt = $con->query($sql);
?>
<table class="table table-striped table-responsive">
    <thead>
    <tr>
        <th>Card Application Number</th>
        <th>Card Type</th>
        <th>Reason</th>
        <th>Apply Date</th>
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
                <td><?php echo $row['card_application_number'];?></td>
                <td><?php echo $row['card_type'];?></td>
                <td><?php echo $row['reason'];?></td>
                <td><?php echo $row['startdate'];?></td>
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

