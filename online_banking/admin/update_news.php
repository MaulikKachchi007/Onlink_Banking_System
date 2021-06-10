<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_GET['id'];
if (isset($_POST["update_news"])) {
    $news_title = $_POST["news_title"];
    $choose_category = $_POST["select_category"];
    $select_image = $_FILES["new_image"]["name"];
    $news = $_POST["news"];
    $target = "news/" . basename($_FILES["new_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    if (empty($news_title) || empty($choose_category ) || empty($news)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect('view_news.php');
    }else {
        global $con;
        if (!empty($_FILES["new_image"]["name"])) {
            $sql = "Update news SET title='$news_title',category='$choose_category',image='$select_image',news='$news' WHERE id='$get_id'";
        } else{
            $sql = "Update news SET title='$news_title',category='$choose_category',news='$news' WHERE id='$get_id'";
        }
        $stmt = $con->prepare($sql);
        $result = $stmt->execute();
        move_uploaded_file($_FILES["new_image"]["tmp_name"], $target);
        if ($result) {
            $_SESSION['success_message'] = "News Updated Successfully";
            redirect('view_news.php');
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";

        }
    }
}
global $con;
$q = "SELECT * FROM news WHERE id='$get_id'";
$stmt = $con->query($q);
$res = $stmt->execute();
while($row = $stmt->fetch()) {
    $title = $row['title'];
    $category = $row['category'];
    $news = $row['news'];
    $image = $row['image'];
}
?>
<?php
require_once 'include/header.php';
require_once 'include/sidebar.php';
require_once 'include/topbar.php';
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
                                            <h1 class="text-dark">Update News</h1>
                                            <p class="text-muted">Update News Details</p>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Update News</li>
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
                            <form role="form"  action="update_news.php?id=<?php echo $get_id; ?>" enctype="multipart/form-data" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="news_title">News Title</label>
                                        <input class="form-control" type="text" name="news_title" value="<?php echo $title;?>" placeholder="News Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="choose_category">Choose Category</label>
                                        <select name="select_category" id="select_category"class="form-control">
                                            <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                            <option value="Accounts">Accounts</option>
                                            <option value="Loans">Loans</option>
                                            <option value="Server">Service</option>
                                            <option value="Income Tax">Income Tax</option>
                                            <option value="ATM Cards">ATM cards</option>
                                            <option value="Invesment and Deposite">Invesment and Deposite</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="select_image">Select Image :</label>
                                        <img src="news/<?php echo $image;?>" width="120px" height="50px" />
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="new_image" id="customFile">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="news">News</label>
                                        <textarea class="form-control" name="news" placeholder="News" rows="5" cols="25"><?php echo $news; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="update_news" class="btn btn-primary">Update News</button>
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
require_once 'include/footer.php';
?>