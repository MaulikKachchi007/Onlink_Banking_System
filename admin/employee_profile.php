<?php
require_once('include/DB.php');
require_once('include/session.php');
require_once('include/function.php');
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
$get_id = $_SESSION['id'];
confirm_login();
if (isset($_POST["update_employee"])) {
$emp_name = $_POST["ename"];
$l_id = $_POST["l_id"];
$email = $_POST["email"];
$mno = $_POST["mno"];
$photo = $_FILES["photo"]["name"];
$target = "image/" . basename($_FILES["photo"]["name"]);
    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
if (empty($emp_name) || empty($l_id) || empty($email) || empty($mno) || empty($photo)) {
    $_SESSION["error_message"] = "All must fill required.";
}elseif($_FILES['photo']['size'] > 500000 ){
    $_SESSION["error_message"] = "image size must be 5MB or less than.";
}
elseif($imageFileType != "jpg" && $imageFileType != "jpeg" ) {
        $_SESSION['error_message'] = "Sorry, only JPG files are allowed.";
        $uploadOk = 0;
    }else {
    global $con;
    if (!empty($_FILES["photo"]["name"])) {
        $sql = "Update employees_master SET ename='$emp_name',loginid='$l_id',email='$email',contact='$mno',photo='$photo' WHERE id='$get_id'";
    }else{
        $sql = "Update employees_master SET ename='$emp_name',loginid='$l_id',email='$email',contact='$mno' WHERE id='$get_id'";
    }
    $stmt = $con->prepare($sql);
    $result = $stmt->execute();
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target);

    if ($result) {
        $_SESSION['success_message'] = "Employee Updated Successfully";
        redirect('index.php');
    } else {
        $_SESSION['error_message'] = "Something went wrong. Try again!";
        redirect('index.php');
    }
}
}
?>
<?php
    global $con;
    $sql = "SELECT * FROM employees_master WHERE id='$get_id'";
    $stmt= $con->query($sql);
    $result = $stmt->execute();
    if ($row = $stmt->fetch()) {
        $ifsccode = $row['ifsccode'];
        $image = $row['photo'];
        $ename = $row['ename'];
        $loginid = $row['loginid'];
        $email = $row['email'];
        $contact = $row['contact'];
        $employee_type = $row['employee_type'];
    }
    $q = "SELECT * FROM branch WHERE ifsccode='$ifsccode'";
    $stmt = $con->query($q);
    $result = $stmt->execute();
    if ($row = $stmt->fetch()) {
        $bname = $row['bname'];
        $state = $row['state'];
        $city =  $row['city'];
        $address = $row['address'];
        $country = $row['country'];
    }
?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
?>
    <!-- Main content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img  img-circle"
                                         src="image/<?php  echo $image;  ?>"
                                         alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center"><?php echo $_SESSION['ename']; ?></h3>

                                <p class="text-muted text-center"><?php echo $employee_type; ?></p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Name</b> <a class="float-right"><?php echo $_SESSION['ename']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Employee Positions</b> <a class="float-right"><?php echo $employee_type; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Employee Positions</b> <a class="float-right"><?php echo $employee_type; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Contact</b> <a class="float-right"><?php echo $contact; ?></a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <div class="Card-title"><h2>Employee Profile</h2></div>
                            </div><!-- /.card-header -->
                            <?php
                            echo SuccessMessage();
                            echo ErrorMessage();
                            ?>
                            <div class="card-body">

                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="settings">
                                        <!-- form start -->
                                        <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="branch">Branch</label>
                                                    <select class="form-control" name="ifsc_code" disabled>
                                                        <option value="<?php echo $ifsccode; ?>"  selected><?php echo $bname; ?>: (<?php echo $ifsccode;  ?> <?php echo $address; ?>,<?php echo $city; ?>, <?php echo $state; ?>, <?php echo $country ?>)</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="emp_name">Employee Name</label>
                                                    <input class="form-control" type="text" name="ename" value="<?php echo $ename; ?>" placeholder="Employee Name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="loginid">Login ID</label>
                                                    <input class="form-control" type="text" name="l_id" value="<?php echo $loginid; ?>" placeholder="Login Id">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email ID</label>
                                                    <input class="form-control" type="email" name="email" value="<?php echo $email; ?>" placeholder="Email ID">
                                                </div>
                                                <div class="form-group">
                                                    <label for="mno">Contact No</label>
                                                    <input class="form-control" name="mno" type="text" value="<?php echo $contact; ?>" placeholder="Contact No">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Photo">Photo</label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" name="photo" class="custom-file-input" id="exampleInputFile">
                                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        </div>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text" id="">Upload</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="e_type">Employee Type</label>
                                                    <input class="form-control" name="e_Type" type="text" disabled value="<?php echo $employee_type; ?>" placeholder="Employee Type">
                                                </div>

                                                <div class="form-group">
                                                    <button type="submit" name="update_employee" class="btn btn-primary">Update Record</button>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content -->
<!-- /.content-wrapper -->
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<?php
include 'include/footer.php';
?>