<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_SESSION['c_id'];
$sql = "SELECT * FROM cards INNER JOIN card_type_master ON cards.id=card_type_master.id";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $card_type = $row['card_type'];
}
?>
<?php
require_once 'include/header.php';
require_once 'include/topbar.php';
require_once 'include/sidebar.php';
?>
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="assets/dist/css/style.css">
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">Views Cards Accounts</h1>
                                <p class="text-muted">Views Cards Records</p>
                            </div>
                            <div class="pull-right" style="text-align: right;">
                                <a href="add_card.php" class="btn btn-info"><i class="fas fa-plus"></i> Apply For Cards</a>
                                <a href="card_status.php" class="btn btn-info"><i class="fas fa-reply"></i> Card Status</a>
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
                                        <th>Card Application Number</th>
                                        <th>Card Number</th>
                                        <th>Card Type</th>
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
                                    INNER JOIN customers_master ON customers_master.c_id=cards.c_id WHERE customers_master.c_id='$get_id' and cards.status='Approved'";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowcount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $card_id = $row['card_id'];
                                            $card_application_number = $row['card_application_number'];
                                            $f_name = $row['f_name'];
                                            $card_no = $row['card_no'];
                                            $enddate = $row['enddate'];
                                            $reason  = $row['reason'];
                                            $startdate = $row['startdate'];
                                            $enddate = $row['enddate'];
                                            $cvv = $row['cvv'];
                                            $status = $row['status'];
                                            ?>

                                            <tr>
                                                <td><?php echo $f_name; ?></td>
                                                <td><?php echo $card_application_number; ?></td>
                                                <td><?php echo str_pad(substr($card_no,-2),16,'X',STR_PAD_LEFT); ?></td>
                                                <td><?php echo $card_type;  ?></td>
                                                <td><?php echo $startdate;?></td>
                                                <td><?php echo $enddate;?></td>
                                                <td><?php echo str_pad(substr($cvv,-1),3,'X',STR_PAD_LEFT);;?></td>
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
                                                            <li><a class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $card_id; ?>"><i class="menu-icon icon-edit"></i>View</a></li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $card_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Views Cards Accounts</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                                <div class="atm-card">
                                                                                    <div class="flip">
                                                                                        <div class="front">
                                                                                            <div class="strip-bottom"></div>
                                                                                            <div class="strip-top"></div>
                                                                                            <div>
                                                                                                <img class="logo" src="image/avtar.png" alt="Bank Logo">
                                                                                                <h3 class="investor">Prime Bank</h3>
                                                                                            </div>
                                                                                            <div class="chip">
                                                                                                <div class="chip-line"></div>
                                                                                                <div class="chip-line"></div>
                                                                                                <div class="chip-line"></div>
                                                                                                <div class="chip-line"></div>
                                                                                                <div class="chip-main"></div>
                                                                                            </div>
                                                                                            <svg class="wave" viewBox="0 3.71 26.959 38.787" width="26.959" height="38.787" fill="white">
                                                                                                <path d="M19.709 3.719c.266.043.5.187.656.406 4.125 5.207 6.594 11.781 6.594 18.938 0 7.156-2.469 13.73-6.594 18.937-.195.336-.57.531-.957.492a.9946.9946 0 0 1-.851-.66c-.129-.367-.035-.777.246-1.051 3.855-4.867 6.156-11.023 6.156-17.718 0-6.696-2.301-12.852-6.156-17.719-.262-.317-.301-.762-.102-1.121.204-.36.602-.559 1.008-.504z"></path>
                                                                                                <path d="M13.74 7.563c.231.039.442.164.594.343 3.508 4.059 5.625 9.371 5.625 15.157 0 5.785-2.113 11.097-5.625 15.156-.363.422-1 .472-1.422.109-.422-.363-.472-1-.109-1.422 3.211-3.711 5.156-8.551 5.156-13.843 0-5.293-1.949-10.133-5.156-13.844-.27-.309-.324-.75-.141-1.114.188-.367.578-.582.985-.542h.093z"></path>
                                                                                                <path d="M7.584 11.438c.227.031.438.144.594.312 2.953 2.863 4.781 6.875 4.781 11.313 0 4.433-1.828 8.449-4.781 11.312-.398.387-1.035.383-1.422-.016-.387-.398-.383-1.035.016-1.421 2.582-2.504 4.187-5.993 4.187-9.875 0-3.883-1.605-7.372-4.187-9.875-.321-.282-.426-.739-.266-1.133.164-.395.559-.641.984-.617h.094zM1.178 15.531c.121.02.238.063.344.125 2.633 1.414 4.437 4.215 4.437 7.407 0 3.195-1.797 5.996-4.437 7.406-.492.258-1.102.07-1.36-.422-.257-.492-.07-1.102.422-1.359 2.012-1.075 3.375-3.176 3.375-5.625 0-2.446-1.371-4.551-3.375-5.625-.441-.204-.676-.692-.551-1.165.122-.468.567-.785 1.051-.742h.094z"></path>
                                                                                            </svg>
                                                                                            <div class="atm-card-number">
                                                                                                <div class="section"><?php echo substr($card_no,0,4); ?></div>
                                                                                                <div class="section"><?php echo substr($card_no,4,4); ?></div>
                                                                                                <div class="section"><?php echo substr($card_no,8,4); ?></div>
                                                                                                <div class="section"><?php echo substr($card_no,12,4); ?></div>
                                                                                            </div>
                                                                                            <div class="end"><span class="end-text">Exp. end:</span><span class="end-date"> <?php echo substr($enddate, 5,2); ?> / <?php echo substr($enddate,8,2);?></span></div>
                                                                                            <div class="atm-card-holder">
                                                                                               <?php
                                                                                                    if($row['gender'] == 'Male'){
                                                                                                        echo 'Mr.'.$f_name.' '.$row['l_name'];
                                                                                                    }elseif($row['gender'] == 'Female'){
                                                                                                        echo 'Mrs.'.$f_name.' '.$row['l_name'];
                                                                                                    }
                                                                                                ?>


                                                                                            </div>
                                                                                            <div class="master">
                                                                                                <div class="circle master-red"></div>
                                                                                                <div class="circle master-yellow"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="back">
                                                                                            <div class="strip-black"></div>
                                                                                            <div class="ccv">
                                                                                                <label>ccv</label>
                                                                                                <div><?php echo $row['cvv']; ?></div>
                                                                                            </div>
                                                                                            <div class="terms">
                                                                                                <p>This atm-card is property of OctoPrime e-Bank, Wonderland. Misuse is criminal offence. If found, please return to Monzo Bank or to the nearest bank with Masteratm-card logo.</p>
                                                                                                <p>Use of this atm-card is subject to the credit card agreement.</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                                                </div>
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
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<?php
include 'include/footer.php';
?>
<script type="text/javascript">

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
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>