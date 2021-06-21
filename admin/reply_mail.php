<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
$g_id = $_SESSION['id'];
if (isset($_POST["send_Message"])) {
    $account_number = $_POST['account_number'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $status = "Adminstrator Replied";
    if (empty($account_number) || empty($subject) || empty($status)) {
        $_SESSION["error_message"] = "All must fill required.";
    }else {
        global $con;
        $sql = "INSERT INTO mail(subject,admin_response,account_no,status,sender_id,reciverid) VALUES (:subject,:admin_response,:account_no,:status,:sender_id,:receiver_id)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':subject',$subject);
        $stmt->bindValue(':admin_response',$message);
        $stmt->bindValue(':account_no',$account_number);
        $stmt->bindValue(':status',$status);
        $stmt->bindValue(':sender_id',$get_id);
        $stmt->bindValue(':receiver_id',$g_id);
        $result = $stmt->execute();
        var_dump($result);
        if ($result) {
            $_SESSION['success_message'] = "Mail Send Successfully";
            redirect('view_message.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
            redirect('view_message.php');
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
                            <?php $get_id = $_GET['id'];?>
                            <form role="form" action="reply_mail.php?id=<?php echo $get_id; ?>" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="account_number">Account Number</label>
                                        <?php
                                        $sql = "SELECT * FROM accounts  INNER JOIN  customers_master ON accounts.c_id = customers_master.c_id";
                                        $stmt = $con->query($sql);
                                        while ($row = $stmt->fetch())
                                        {
                                            $f_name = $row['f_name'];
                                            $l_name = $row['l_name'];
                                            $account_no = $row['account_no'];
                                        }
                                        ?>
                                        <input class="form-control" name="account_number" value="<?php echo $account_no; ?> (<?php  echo $f_name; ?> <?php echo  $l_name;?>)" type="text" readonly placeholder="Account Number">
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
        })
    </script>
<?php
include 'include/footer.php';
?>