<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$get_id = $_SESSION['id'];
global $con;
$sql = "SELECT * from loan_type_master 
        INNER JOIN loan ON loan_type_master.id=loan.id";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $loan_id = $row['loan_id'];
    $loan_account_number = $row['loan_account_number'];
    $l_type = $row['loan_type'];
    $loan_amount = $row['loan_amount'];
    $interest = $row['intrest'];
    $loan_interest = $row['interest'];
    $term = "$row[terms] years";
    $created_date = $row['created_date'];
    $total_payable = $loan_amount + $interest;
    $status = $row['status'];
}
?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
?>
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">View Loan Accounts</h1>
                                <p>View Loan Accounts</p>
                            </div>

                            </div>
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
                                        <th>Customer Name</th>
                                        <th>Loan Account Number</th>
                                        <th>Loan Type</th>
                                        <th>Created Date</th>
                                        <th>Last Date</th>
                                        <th>Loan Amount</th>
                                        <th>Interest Amount</th>
                                        <th>Total Payble</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT * from customers_master 
                                         INNER JOIN loan ON customers_master.c_id=loan.c_id";
                                    $stmt = $con->query($sql);
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()){
                                            $f_name = $row['f_name'];
                                            $l_name = $row['l_name'];
                                            $loan_id = $row['loan_id'];
                                            $loan_account_number = $row['loan_account_number'];
                                            $loan_amount = $row['loan_amount'];
                                            $interest = $row['intrest'];
                                            $created_date = $row['created_date'];
                                            $total_payable = $loan_amount + $interest;
                                            $status = $row['status'];
                                            $loan_account_number = $row['loan_account_number'];
                                            ?>
                                            <tr>
                                                <td><?php echo $f_name; ?></td>
                                                <td><?php echo $loan_account_number; ?></td>
                                                <td><?php echo $l_type; ?></td>
                                                <td><?php echo $created_date; ?></td>
                                                <td><?php echo date('d-M-Y', strtotime($term, strtotime($created_date))); ?></td>
                                                <td>&#8377; <?php echo $loan_amount;?></td>
                                                <td>&#8377; <?php echo $interest;?> (<?php echo $loan_interest; ?>)</td>
                                                <td>&#8377; <?php echo $total_payable;?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="view_loan_accounts_detail.php?id=<?php echo $loan_account_number; ?>" class="dropdown-item"> View</a></li>
                                                        </ul>
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
<?php
include 'include/footer.php';
?>
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