<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$get_id = $_SESSION['id'];
global $con;
if (isset($_POST['verify_card'])) {
    $get_id = $_GET['id'];
    $cardstatus = $_POST["cardstatus"];
    $q = "UPDATE cards SET status='$cardstatus' WHERE card_id='$get_id'";
    $stmt = $con->prepare($q);
    $result = $stmt->execute();
    if ($result) {
        $_SESSION['success_message'] = "Pending Load Request Verify.";
        redirect('pending_card_request.php');
    } else {
        $_SESSION['error_message'] = "Something went wrong. Try again!";
        redirect('pending_card_request.php');
    }
}
$get_id = $_SESSION['id'];
$q = "SELECT * FROM employees_master WHERE id='$get_id'";
$stmt = $con->query($q);
$result = $stmt->execute();
if ($row = $stmt->fetch()){
    $ifsccode = $row['ifsccode'];
}
$sql = "SELECT * FROM cards INNER JOIN card_type_master ON cards.id=card_type_master.id";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $card_type = $row['card_type'];
}
?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
?>
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">View Card Request</h1>
                                <p>View Pending Card Requests</p>
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
                                        <th>IFSC Code</th>
                                        <th>Customer Name</th>
                                        <th>Card Application Number</th>
                                        <th>Card Number</th>
                                        <th>Card Type</th>
                                        <th>Reason</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>CVV</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $sql = "SELECT * from cards 
                                    INNER JOIN customers_master ON customers_master.c_id=cards.c_id WHERE customers_master.ifsccode='$ifsccode'";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $card_id = $row['card_id'];
                                            $card_application_number = $row['card_application_number'];
                                            $f_name = $row['f_name'];
                                            $card_no = $row['card_no'];
                                            $reason  = $row['reason'];
                                            $startdate = $row['startdate'];
                                            $enddate = $row['enddate'];
                                            $cvv = $row['cvv'];
                                            $status = $row['status'];
                                            $ifsc_code = $row['ifsccode'];
                                            ?>
                                            <tr>
                                                <td><?php echo $ifsc_code;?></td>
                                                <td><?php echo $f_name; ?></td>
                                                <td><?php echo $card_application_number; ?></td>
                                                <td><?php echo $card_no; ?></td>
                                                <td><?php echo $card_type;  ?></td>
                                                <td><?php echo $reason; ?></td>
                                                <td><?php echo $startdate;?></td>
                                                <td><?php echo $enddate;?></td>
                                                <td><?php echo $cvv;?></td>
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
                                                            <li><a  class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $card_id; ?>">View</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $card_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                            <th>Card Application Number</th>
                                                                            <td><?php echo $row['card_application_number']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Card Number</th>
                                                                            <td><?php echo $row['card_no']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Card Type</th>
                                                                            <td><?php echo $card_type; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Reason</th>
                                                                            <td><?php echo $row['reason']; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Start Date</th>
                                                                            <td><?php echo $startdate; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>End Date</th>
                                                                            <td><?php echo $enddate; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>CVV</th>
                                                                            <td><?php echo $cvv; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Status</th>
                                                                            <td>
                                                                                <form method="post" action="pending_card_request.php?id=<?php echo $card_id; ?>">
                                                                                    <select name="cardstatus" class="form-control">
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
                                                                    <button  type="submit" name="verify_card" class="btn btn-success">Verify Cards</button>
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