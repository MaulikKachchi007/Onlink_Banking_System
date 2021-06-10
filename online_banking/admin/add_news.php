<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
if (isset($_POST["add_record"])) {
    $news_title = $_POST["news_title"];
    $choose_category = $_POST["select_category"];
    $select_image = $_FILES["new_image"]["name"];
    $news = $_POST["news"];
    $target = "news/" . basename($_FILES["new_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target,PATHINFO_EXTENSION));
    $status = $_POST["status"];
    if (empty($news_title) || empty($choose_category) || empty($news) || empty($status)) {
        $_SESSION["error_message"] = "All must fill required.";
        redirect("add_news.php");
    } elseif($_FILES["new_image"]["size"] >= 300000 ){
        $_SESSION["error_message"] = "image size must be 3MB or less than.";
        redirect("add_news.php");
    }
//    elseif($imageFileType != "jpg" && $imageFileType != "jpeg" ) {
//        $_SESSION['error_message'] = "Sorry, only JPG files are allowed.";
//        redirect("add_news.php");
//    }
    elseif (strlen($news) < 100) {
        $_SESSION["error_message"] = "News must be 100 characters.";
        redirect("add_news.php");
    } else {
        global $con;
        $sql = "INSERT INTO news (title,category,image,news,status)
                VALUES (:title,:category,:image,:news,:status)";
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':title',$news_title);
        $stmt->bindValue(':category',$choose_category);
        $stmt->bindValue(':image',$select_image);
        $stmt->bindValue(':news',$news);
        $stmt->bindValue(':status',$status);
        move_uploaded_file($_FILES["new_image"]["tmp_name"], $target);
        $result = $stmt->execute();

        if ($result) {
            $_SESSION['success_message'] = "News Added Successfully";
        }else{
            $_SESSION['error_message'] = "Something went wrong. Try again!";
            redirect("add_news.php");
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
                                            <h1 class="text-dark">Add News</h1>
                                            <p class="text-muted">Enter News Details</p>
                                        </div><!-- /.col -->
                                        <div class="col-sm-6">
                                            <ol class="breadcrumb float-sm-right">
                                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                                <li class="breadcrumb-item active">Add News</li>
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
                            <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="news_title">News Title</label>
                                        <input class="form-control" type="text" name="news_title" placeholder="News Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="choose_category">Choose Category</label>
                                        <select name="select_category" id="select_category"class="form-control">
                                            <option value="Select">Select</option>
                                            <option value="Accounts">Accounts</option>
                                            <option value="Loans">Loans</option>
                                            <option value="Server">Service</option>
                                            <option value="Income Tax">Income Tax</option>
                                            <option value="ATM Cards">ATM cards</option>
                                            <option value="Invesment and Deposite">Invesment and Deposite</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="select_image">Select Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="new_image" id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="news">News</label>
                                        <textarea class="form-control" name="news" placeholder="News" rows="5" cols="25"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="None" selected>None</option>
                                            <option value="Active" >Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="add_record" class="btn btn-primary">Add Record</button>
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