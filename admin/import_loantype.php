<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
global $con;
if (isset($_POST['add_import_account'])) {
    $filename = $_FILES['file']['tmp_name'];
    if ($_FILES['file']['size'] > 0) {
        $file = fopen($filename, "r");
        while (($line = fgetcsv($file,10000,",")) !== false) {
            $sql = "INSERT INTO loan_type_masters (loan_type,prefix,min_amt,max_amt,interest,status) VALUES('". $line[0] ."','". $line[1] ."','". $line[2] ."','". $line[3] ."','". $line[4] ."','". $line[5] ."') ";
            $stmt = $con->prepare($sql);
            $result = $stmt->execute();
            if (isset($result)) {
                $_SESSION['success_message'] = "Record Import Successfully.";
            }else{
                $_SESSION['error_message'] = "Something This Wrong! Try again later.";
            }
        }
    }
    fclose($file);
}
?>
<?php
include_once 'include/header.php';
include_once 'include/sidebar.php';
include_once 'include/topbar.php';
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
                                            <h1 class="text-dark">User Import Account</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add Import Loan Type</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_account.php" class="btn btn-info float-right text-white">View Record</a>
                            </div>
                            <div class="container p-1">
                                <?php
                                echo ErrorMessage();
                                echo SuccessMessage();
                                ?>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" name="file" class="custom-file-input" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <button type="submit" name="add_import_account" class="btn btn-primary">Import Record</button>
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
include_once 'include/footer.php';
?>

