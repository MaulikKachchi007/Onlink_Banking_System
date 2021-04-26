<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
global $con;
$get_id = $_SESSION['id'];
$q = "SELECT * FROM employees_master WHERE id ='$get_id'";
$stmt = $con->query($q);
$stmt->execute();
$row = $stmt->fetch();
$ifsc_code = $row['ifsccode'];

$q = "SELECT * FROM branch WHERE ifsccode='$ifsc_code'";
$stmt = $con->query($q);
$res = $stmt->execute();
while($row = $stmt->fetch()) {
    $icode = $row["ifsccode"];
    $bname = $row["bname"];
    $add = $row["address"];
    $bcity = $row["city"];
    $bstate = $row["state"];
    $bcountry = $row["country"];
    $status = $row["status"];
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
                            <div class="card-title"><h1 class="text-dark">Branch Details</h1>
                                <p class="text-muted">Branch Details</p>
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
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>IFSC Code</th>

                                            <td><?php echo $icode; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Branch Name</th>
                                            <td><?php echo $bname; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td><?php echo $add; ?></td>
                                        </tr><tr>
                                            <th>City</th>
                                            <td><?php echo $bcity; ?></td>
                                        </tr>
                                        <tr>
                                            <th>state</th>
                                            <td><?php echo $bstate; ?></td>
                                        </tr>
                                        <tr>
                                            <th>country</th>
                                            <td><?php echo $bcountry ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><?php echo $status ?></td>
                                        </tr>
                                    </table>

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
