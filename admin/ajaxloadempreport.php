<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
global $con;
?>
<div class="card card-primary">
    <div class="card-header border-0">
        <h3 class="card-title">Employee Statement</h3>
        <div class="card-tools">
            <a href="export_employee_pdf_report.php?fromDate=<?php echo $fromDate;?>&toDate=<?php echo $toDate;?>" class="btn btn-tool btn-sm">
                <i class="fas fa-download"></i>
            </a>
        </div>
    </div>
    <div class="card card-body">
        <table id="example1" class="table table-striped table-bordered table-responsive">
            <thead>
            <tr>
                <th>IFSC Code</th>
                <th>Employee Name</th>
                <th>Login ID</th>
                <th>Email ID</th>
                <th>Contact</th>
                <th>Employee Type</th>
                <th>Join Date</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?php
                global $con;
                $sql = "SELECT * FROM employees_master
                        WHERE create_date BETWEEN '$fromDate' AND '$toDate'";
                $stmt = $con->query($sql);
                $rcount = $stmt->rowCount();
                if ($rcount > 0) {
                while ($row = $stmt->fetch()) {
                $ename = $row['ename'];
                $loginid = $row['loginid'];
                $email = $row['email'];
                $ifsccode = $row['ifsccode'];
                $contact = $row['contact'];
                $employee_type = $row['employee_type'];
                $status = $row['status'];
                $create_date = $row['create_date'];
                ?>
                <td><?php echo $ifsccode;?></td>
                <td><?php echo $ename;?></td>
                <td><?php echo $loginid;?></td>
                <td><?php echo $email;?></td>
                <td><?php echo $contact;?></td>
                <td><?php echo $employee_type;?></td>
                <td><?php echo $create_date;?></td>
                <td><?php echo $status;?></td>
            </tr>
            <?php
            }
            }else{
                echo "<tr><td colspan='9' class='text-bold text-center text-danger'>No Record Found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>