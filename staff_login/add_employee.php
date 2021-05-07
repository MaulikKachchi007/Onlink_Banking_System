<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
global $con;
$get_id = $_SESSION['id'];
$q = "SELECT * FROM employees_master WHERE id ='$get_id'";
$stmt = $con->query($q);
$stmt->execute();
$row = $stmt->fetch();
$ifsc_code = $row['ifsccode'];
if (isset($_POST["add_employee"])) {
    $ifsc_code = $_POST["branch"];
    $emp_name = $_POST["emp_name"];
    $l_id = $_POST["l_id"];
    $email = $_POST["email"];
    $mno = $_POST["mno"];
    $pwd = $_POST["pwd"];
    $cpwd = $_POST["cpwd"];
    $token = bin2hex(random_bytes(15));
    $e_type = $_POST["e_type"];
    $status = $_POST["status"];
    if (empty($ifsc_code) || empty($emp_name ) || empty($l_id) || empty($pwd) || empty($cpwd) || empty($email) || empty($mno) || empty($e_type) || empty($status)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('add_employee.php');
    }elseif($pwd!=$cpwd){
        $_SESSION["error_message"] = "Password and Confirm Password Not Match.";
        redirect('add_employee.php');
    }else {
        global $con;
        $sql = "INSERT INTO employees_master(ifsccode,ename,loginid,email,contact,pwd,token,employee_type,status)
        VALUES(:ifsccode,:ename,:loginid,:email,:contact,:pwd,$token,:employee_type,:status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':ifsccode',$ifsc_code);
        $stmt->bindValue(':ename',$emp_name);
        $stmt->bindValue(':loginid',$l_id);
        $stmt->bindValue(':email',$email);
        $stmt->bindValue(':contact',$mno);
        $stmt->bindValue(':pwd',$pwd);
        $stmt->bindValue(':token',$token);
        $stmt->bindValue(':employee_type',$e_type);
        $stmt->bindValue(':status',$status);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Employee  Added Successfully";
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
        }
    }
}
?>
<?php
include 'include/header.php';
 include 'include/sidebar.php';
include 'include/topbar.php';
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
                                            <h1 class="text-dark">Add Employee</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Employee</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_employee.php" class="btn btn-info float-right text-white">View Record</a>
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
                                        <label for="emp_name">Branch</label>
                                        <select class="form-control" name="branch">
                                            <option value="None" selected>None</option>
                                            <?php
                                                global $con;
                                                $q = "SELECT * FROM branch WHERE ifsccode='$ifsc_code'";
                                                $stmt = $con->query($q);
                                                $stmt->execute();
                                                while ($row = $stmt->fetch()) {
                                                    $icode = $row['ifsccode'];
                                                    $branch_name = $row['bname'];
                                                    $add = $row['address'];
                                                    $state = $row['state'];
                                                    $country = $row['country'];
                                                 ?>
                                                    echo '<option value="<?php echo $icode; ?>"><?php echo $branch_name; ?> (<?php echo $icode; ?>) <?php echo $add;?>  <?php echo $state; ?> <?php echo $country; ?></option>';
                                            <?php
                                                }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="emp_name">Employee Name</label>
                                        <input class="form-control" type="text" name="emp_name" placeholder="Employee Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="loginid">Login ID</label>
                                        <input class="form-control" type="text" name="l_id" placeholder="Login ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email ID</label>
                                        <input class="form-control" type="email" name="email" placeholder="Email ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="contact">Contact Number</label>
                                        <input class="form-control" type="text" name="mno" placeholder="Contact Number">
                                    </div>
                                    <div class="form-group">
                                        <label for="pwd">Password</label>
                                        <input class="form-control" type="password" name="pwd" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="cpwd">Confirm Password</label>
                                        <input class="form-control" type="password" name="cpwd" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="e_type">Employee Type</label>
                                        <select class="form-control" name="e_type">
                                            <option value="None" selected>None</option>
                                            <option value="Admin" >Admin</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Staff" >Staff</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="Status">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="None" selected>None</option>
                                            <option value="Active" >Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="add_employee" class="btn btn-primary">Add Employee</button>
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
<?php
include 'include/footer.php';
?>
