<?php
require_once ('include/DB.php');
require_once ('include/session.php');
require_once ('include/function.php');
?>
<?php
$get_id = $_SESSION['c_id'];
if (isset($_POST['change_pin'])){
    $old_pin = base64_encode($_POST['old_pin']);
    $new_pin = base64_encode($_POST['new_pin']);
    $confirm_pin = base64_encode($_POST['confirm_pin']);
    if(!empty($old_pin)||!empty($new_pin) || !empty($confirm_pin)) {

        if (strlen(base64_decode($new_pin))  > 6) {
            $_SESSION['error_message'] = "Your Pin Less than 6 characters!";
            redirect('change_pin_password.php');
        }elseif(!preg_match("#[0-9]+#",base64_decode($new_pin))) {
            $_SESSION['error_message'] = "Your Pin Must Contain At Least 6 Number!";
            redirect('change_pin_password.php');
        }else {
            #Request for Email code and check email
            global $con;
            $q = "SELECT * from customers_master where c_id='$get_id' AND pin='$old_pin'";
            $stmt = $con->query($q);
            $crow  = $stmt->rowcount();
            if ($crow > 0) {
                $sql = "UPDATE customers_master SET pin =:new_Pin where c_id =:id";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(':id', $get_id);
                $stmt->bindValue(':new_Pin', $new_pin);
                $res = $stmt->execute();
                if ($res) {
                    $_SESSION["success_message"] = "New Pin Change successfully";
                    redirect('index.php');
                } else {
                    $_SESSION["error_message"] = "Incorrect New Pin!";
                    redirect('change_pin_password.php');
                }
            }else{
                $_SESSION["error_message"] = "Incorrect Old Pin!";
                redirect('change_pin_password.php');
            }
        }
    }else{
        $_SESSION['error_message'] = "All Fill Must Required.";
        redirect('change_pin_password.php');
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
                                        <h1 class="text-dark">Change Transaction Pin</h1>
                                        <p class="text-muted">Enter a Change Transaction Pin</p>
                                    </div><!-- /.col -->
                                    <div class="col-sm-6">
                                        <ol class="breadcrumb float-sm-right">
                                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                            <li class="breadcrumb-item active">Change Pin</li>
                                        </ol>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                            </div>
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
                                    <label for="old_pwd">Old Pin</label>
                                    <input class="form-control" type="password" name="old_pin"  placeholder="Old Pin">
                                </div>
                                <div class="form-group">
                                    <label for="new_pwd">New Password</label>
                                    <input class="form-control" type="password" name="new_pin"  placeholder="New Password">
                                </div>
                                <div class="form-group">
                                    <label for="old_pwd">Confirm Password</label>
                                    <input class="form-control" type="password" name="confirm_pin"  placeholder="Confirm Password">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="change_pin">Change Transaction Pin</button>
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
