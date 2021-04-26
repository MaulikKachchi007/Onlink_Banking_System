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
while ($row = $stmt->fetch()){
    $ifsccode = $row['ifsccode'];
}
if (isset($_POST["send_Message"])) {
    $account_number = $_POST['c_name'];
    $subject = $_POST['subject'];
    $admin_response = $_POST['message'];
    $account_no = substr($account_number,0,13);
    $sender_id = substr($account_number,13,14);
    $status = "Adminstrator Replied";
    if (empty($account_number) || empty($subject) || empty($status)) {
        $_SESSION["error_messagqe"] = "All must fill required.";
    } else {
        global $con;
        $sql = "INSERT INTO mail(subject,account_no,status,sender_id,reciverid,admin_response)
                VALUES (:subject,:account_no,:status,:sender_id,:reciverid,:admin_response)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':subject', $subject);
        $stmt->bindValue(':account_no', $account_no);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':sender_id', $sender_id);
        $stmt->bindValue(':reciverid', $get_id);
        $stmt->bindValue(':admin_response', $admin_response);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "Mail Send Successfully";
            redirect('view_send_message.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong. Try again!";
            redirect('view_send_message.php');;
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
                                            <h1 class="text-dark">Send Message</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Send Message</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_message.php" class="btn btn-info float-right text-white"><i class="fas fa-reply"></i> View Message</a>
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
                                        <label for="c_name">Customer Name</label>
                                        <select class="form-control" name="c_name">
                                            <option value="Select">Select</option>
                                            <?php
                                            global $con;
                                            $sql = "SELECT * FROM customers_master INNER JOIN accounts ON customers_master.c_id = accounts.c_id WHERE customers_master.ifsccode='$ifsccode' and accounts.account_type='Saving Account' or accounts.account_type='Current  Account'";
                                            $stmt = $con->query($sql);
                                            while ($row = $stmt->fetch())
                                            {
                                                $g_id = $row['c_id'];
                                                $account_no = $row['account_no']; 
                                                $f_name = $row['f_name'];
                                                $l_name = $row['l_name'];
                                            ?>
                                                <option value="<?php echo $row['account_no']; echo $g_id;?>"><?php echo $row['account_no'];?> <?php echo $f_name;?> <?php echo $l_name;?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label for="Subject">Subject</label>
                                        <input class="form-control" name="subject" placeholder="Subject">
                                    </div>
                                    <div class="form-group">
                                        <label for="Message">Message</label>
                                        <textarea name="message" class="form-control"  cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="send_Message" class="btn btn-primary">Send Message</button>
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
    <script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- Page Script -->
    <script>
        $(function () {
            //Add text editor
            $('#compose-textarea').summernote()
        })</script>
<?php
include 'include/footer.php';
?>

