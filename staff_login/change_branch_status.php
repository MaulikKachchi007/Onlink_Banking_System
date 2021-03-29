<?php
include('include/DB.php');
//include('include/session.php');
include('include/function.php');
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST['verify_branch'])) {
    $get_id = $_GET['id'];
    global $con;
    $change_status='';
    $qr = "SELECT * FROM branch WHERE bid='$get_id'";
    $stmt = $con->query($qr);
    $stmt->execute();
    $row = $stmt->fetch();
        $change_status = $row['status'];
    if ($change_status == 'Inactive') {
        $sql = "Update branch SET status='active' WHERE bid='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Branch Verify.!";
            redirect('view_branch.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_branch.php');
        }
    }
    elseif ($change_status == 'active') {
        echo $change_status;
        $sql = "Update branch SET status='Inactive' WHERE bid='$get_id'";
        echo $sql;
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Branch Un-Verify.!";
            redirect('view_branch.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_branch.php');
        }
    }
}

?>
<?php
global $con;
$q = "SELECT * FROM branch WHERE bid='$get_id'";
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
include('include/header.php');
include('include/topbar.php');
include('include/sidebar.php');
?>
    <div class="content-wrapper">
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card card-default mt-2">
                            <div class="card-header">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6 col-md-6">
                                            <h1 class="text-dark">Verify Branch</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Verify Branch</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_branch.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
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
                                <tr>
                                    <td></td>
                                    <td>
                                        <form method="post" action="change_branch_status.php?id=<?php echo $get_id; ?>">
                                            <?php if ($status == "active") {
                                                ?>
                                                <button type="submit" name="verify_branch" onclick="confirm('Connfirm Verify Branch');" class="btn btn-danger">Un-Verify Branch</button>
                                                <?php
                                            }
                                            else{
                                                ?>
                                                <button type="submit" name="verify_branch" onclick="confirm('Connfirm Verify Branch');" class="btn btn-success">Verify Branch</button>
                                                <?php
                                            }
                                            ?>
                                        </form>
                                        <!-- /.card -->
                                    </td>
                                 </tr>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php
include('include/footer.php');
?>