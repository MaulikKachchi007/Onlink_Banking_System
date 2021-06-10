<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$get_id = $_SESSION['id'];
global $con;
$q = "SELECT * FROM employees_master WHERE id='$get_id'";
$stmt = $con->query($q);
$result = $stmt->execute();
if ($row = $stmt->fetch()){
    $ifsccode = $row['ifsccode'];
}
if (isset($_POST['verify_loan'])) {
    $loanid = $_GET['id'];
    $loan_status = $_POST["loanstatus"];
    echo $loan_status;
    $q = "UPDATE loan SET status='$loan_status' WHERE loan_id='$loanid'";
    $stmt = $con->prepare($q);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['success_message'] = "Pending Load Request Verify.";
        redirect('pending_loan_request.php');
    } else {
        $_SESSION['error_message'] = "Something went wrong. Try again!";
        redirect('pending_loan_request.php');
    }
}
?>
<?php
require_once 'include/header.php';
require_once 'include/topbar.php';
require_once 'include/sidebar.php';
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">View Loan Request</h1>
                                <p>View Pending Loan Requests</p>
                            </div>

                        <!-- /.card-header -->
                    </div>
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12">
                                <div class="container p-1">
                                    <?php
                                    echo ErrorMessage();
                                    echo SuccessMessage();
                                    ?>
                                </div>
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>IFSC Code</th>
                                        <th>Customer Name</th>
                                        <th>Loan Account Number</th>
                                        <th>Loan Type</th>
                                        <th>Created Date</th>
                                        <th>Loan Amount</th>
                                        <th>Interest Amount</th>
                                        <th>Total Payble</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT customers_master.ifsccode,loan.loan_id,customers_master.l_name,customers_master.f_name,loan.loan_account_number,loan_type_master.loan_type,loan.c_id,loan.created_date,loan_amount,loan.intrest,loan.status from ((loan_type_master 
                                    INNER JOIN loan ON loan_type_master.id=loan.id)
                                    INNER JOIN customers_master ON customers_master.c_id=loan.c_id) WHERE customers_master.ifsccode='$ifsccode'";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $ifsccode=$row['ifsccode'];
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
                                            <tr>
                                                <td><?php echo $ifsccode;?></td>
                                                <td><?php echo $f_name; ?></td>
                                                <td><?php echo $loan_account_number; ?></td>
                                                <td><?php echo $l_type; ?></td>
                                                <td><?php echo $created_date; ?></td>
                                                <td><?php echo $loan_amount;?></td>
                                                <td><?php echo $interest;?></td>
                                                <td><?php echo $total_payable;?></td>
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
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a  class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $loan_id; ?>">View</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $row['loan_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">View Paneding Loan Request</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div  class="modal-body">
                                                                    <table class="table table-bordered table-striped">
                                                                        <tr>
                                                                            <th>Customer Name</th>
                                                                            <td><?php echo $row['f_name']; ?> <?php echo $row['l_name']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Account Number</th>
                                                                            <td><?php echo $row['loan_account_number']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Type</th>
                                                                            <td><?php echo $row['loan_type']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Created Date</th>
                                                                            <td><?php echo $row['created_date']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Loan Amount</th>
                                                                            <td><?php echo $row['loan_amount']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Interest Amount</th>
                                                                            <td><?php echo $row['intrest']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Total Payble</th>
                                                                            <td><?php echo $total_payable; ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <td>
                                                                                <form method="post" action="pending_loan_request.php?id=<?php echo $row['loan_id']; ?>">
                                                                                    <select name="loanstatus" class="form-control">
                                                                                        <option value="Select" selected>Select</option>
                                                                                        <option value="Approved">Approved</option>
                                                                                        <option value="Pending">Pending</option>
                                                                                        <option value="Denied">Denied</option>
                                                                                    </select>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button  type="submit" name="verify_loan" class="btn btn-success">Verify Loan</button>
                                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }else {
                                        $_SESSION['error_message']= "Record not found.";
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
</div>
</section>
</div>
<script>
    $(function () {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
    });
</script>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<?php
include 'include/footer.php';
?>