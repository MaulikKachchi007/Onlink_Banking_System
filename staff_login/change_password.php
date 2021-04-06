<?php
require_once ('include/DB.php');
require_once ('include/session.php');
require_once ('include/function.php');
?>
<?php
$get_id = $_SESSION['id'];
if (isset($_POST['change_pwd'])){
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_Password = $_POST['confirm_password'];

    if(empty($old_password) || empty($new_password) || empty($confirm_Password)) {
        $_SESSION['error_message'] = "All Fill Must Required.";
        redirect('change_password.php');
    }
    else if ($new_password != $confirm_Password) {
        $_SESSION['error_message'] = "Password and Confirm Password Not match.";
        redirect('change_password.php');
    }
    else {
        #Request for Email code and check email
        global $con;
        $sql = "SELECT * from employees_master where id='$get_id' AND pwd='$old_password'";
        $stmt = $con->query($sql);
//        $stmt->bindValue(':iD',$get_id);
//        $stmt->bindValue(':Old_PassWord', $old_password);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if ($stmt->rowCount() > 0) {
            $sql = "UPDATE employees_master SET pwd =:new_PassWord where id =:id";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':id', $get_id);
            $stmt->bindValue(':new_PassWord', $new_password);
            $res = $stmt->execute();
            if ($res) {
                $_SESSION["success_message"] = "New Password Change successfully";
                redirect('index.php');
            } else {
                $_SESSION["error_message"] = "Incorrect New Password!";
                redirect('change_password.php');
            }
        }else{
                $_SESSION["error_message"] = "Incorrect Old Password!";
                redirect('change_password.php');
        }
    }
}

?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
?>
<!-- Main content -->
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
                                        <h1 class="text-dark">Settings</h1>
                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                            <li class="breadcrumb-item active">Change Password</li>
                                        </ol>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div>
                            <a href="view_loan_type.php" class="btn btn-info float-right text-white">View Record</a>
                        </div>
                        <div class="container p-1">
                            <?php
                            echo ErrorMessage();
                            echo SuccessMessage();
                            ?>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="old_pwd">Old Password</label>
                                    <input class="form-control" type="password" name="old_password"  placeholder="Old Password">
                                </div>
                                <div class="form-group">
                                    <label for="new_pwd">New Password</label>
                                    <input class="form-control" type="password" name="new_password"  placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <label for="old_pwd">Confirm Password</label>
                                    <input class="form-control" type="password" name="confirm_password"  placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="change_pwd">Change Password</button>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content -->
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<?php
include 'include/footer.php';
?>
