<?php
include('include/DB.php');
//include('include/session.php');
include('include/function.php');
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST['verify_news'])) {
    $get_id = $_GET['id'];
    global $con;
    $change_status='';
    $qr = "SELECT * FROM news WHERE id='$get_id'";
    $stmt = $con->query($qr);
    $stmt->execute();
    $row = $stmt->fetch();
    $change_status = $row['status'];
    if ($change_status == 'Inactive') {
        $sql = "Update news SET status='Active' WHERE id='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "News Verify.!";
            redirect('view_news.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_news.php');
        }
    } elseif ($change_status == 'Active') {
        $sql = "Update news SET status='Inactive' WHERE id='$get_id'";
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $_SESSION['success_message'] = "News Un-Verify.!";
            redirect('view_news.php');
        } else {
            $_SESSION['error_message'] = "Something went wrong.Try again!";
            redirect('view_news.php');
        }
    }
}

?>
<?php
global $con;
$q = "SELECT * FROM news WHERE id='$get_id'";
$stmt = $con->query($q);
$res = $stmt->execute();
while($row = $stmt->fetch()) {
    $title = $row['title'];
    $id = $row['id'];
    $category = $row['category'];
    $image = $row['image'];
    $news = $row['news'];
    $status = $row['status'];
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
                                            <h1 class="text-dark">Verify News</h1>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Verify News</li>
                                            </ol>
                                        </div><!-- /.col -->
                                    </div><!-- /.row -->
                                </div>
                                <a href="view_news.php" class="btn btn-info float-right text-white">View Record</a>
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
                                    <th>Title</th>
                                    <td><?php echo $title; ?></td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td><?php echo $category; ?></td>
                                </tr>
                                <tr>
                                    <th>Image</th>
                                    <td><img src="news/<?php echo $image;?>" width="170px" height="70px"></td>
                                </tr>
                                <tr>
                                    <th>Post</th>
                                    <td>
                                        <textarea rows="5" readonly class="form-control" cols="50"><?php echo $news; ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <form method="post" action="change_news_status.php?id=<?php echo $get_id; ?>">
                                            <?php if ($status == "Active") {
                                                ?>
                                                <button type="submit" name="verify_news" onclick="confirm('Connfirm Verify Status');" class="btn btn-danger">Un-Verify News</button>
                                                <?php
                                            }
                                            else if($status == "Inactive"){
                                                ?>
                                                <button type="submit" name="verify_news" onclick="confirm('Connfirm Verify Status');" class="btn btn-success">Verify News</button>
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