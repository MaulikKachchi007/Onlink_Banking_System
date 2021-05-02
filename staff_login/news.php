<?php
include 'include/DB.php';
include 'include/function.php';
include 'include/footer.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
?>
<?php
include 'include/header.php';
include 'include/sidebar.php';
include 'include/topbar.php';
?>

<!--Header-->
<div class="content-wrapper">
    <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-default mt-2">
                            <div class="card-header">
                                <div class="card-title"><h1 class="text-dark">News Details</h1>
                                    <p class="text-muted">Views News Records</p>
                                </div>
                            </div>
                        </div>
                </div>
            <div class="card-body">
        <div class="row mt-2">
        <!---Main Area Start-->
        <div class="col-sm-8">
            <?php
                echo ErrorMessage();
                echo SuccessMessage();
            ?>
            <?php
            global $con;
            //Query When Pagination is Active i.g.Blog.php?page=1
            if (isset($_GET["page"])){
                $Page = $_GET["page"];
                if ($Page==0||$Page<    1){
                    $showPostPage=0;
                }
                else{
                    $showPostPage=($Page*5)-5;
                }
                $sql = "SELECT * FROM news ORDER BY id desc LIMIT $showPostPage,4";
                $stmt = $con->query($sql);
            }
//            else{
                $sql = "SELECT * FROM news ORDER BY id DESC";
                $stmt = $con->query($sql);;
//            }
            while ($row = $stmt->fetch()) {
                # code...
                $title = $row['title'];
                $id = $row['id'];
                $category = $row['category'];
                $image = $row['image'];
                $news = $row['news'];
                $datetime = $row['datetime'];
                ?>
                <div class="card">
                    <img src="../admin/news/<?php echo htmlentities($image);?>" style="maxheight:450px;" class="img-fluid">
                    <div class="card-body">
                        <h4 class="card-title"><h2><?php echo htmlentities($title); ?></h2></h4>
                        <br>
                        <small class="text-muted">Category: <a href="#"><?php echo htmlentities($category);?></a> Written By <a href="#"><?php echo htmlentities('Administration');?></a> On <?php echo htmlentities($datetime); ?></small>
                        <hr>
                        <p class="card-text">

                            <?php
                            if (strlen($news)>150) {
                                $postDescription = substr($news,0,150)."...";
                            } echo htmlentities($news);
                            ?>
                        </p>
                        <a href="FullPost.php?id=<?php echo $id?>" style="float:right">
                            <span class="btn btn-info">Read More >></span>
                        </a>
                    </div>
                </div>
                <br>
            <?php } ?>
            <!-- Pagination Start -->
            <nav>
                <ul class="pagination pagination-md ml-4">
                    <!-- Creating Start BackWard Button -->
                    <?php if (isset($Page)) {
                        if ($Page>1) {

                            ?>
                            <li class="page-item">
                                <a href="news.php?page=<?php echo $Page-1; ?>" class="page-link">&laquo;</a>
                            </li>
                        <?php } } ?>
                    <!-- Creating End Backward Button -->
                    <?php
                    global $conDB;
                    $q =  "SELECT * FROM news WHERE status='Active'";
                    $stmt = $con->query($q);
                    while ($row = $stmt->fetch()) {
                        $id = $row['id'];
                    }
                    $sql =  "SELECT COUNT(*) FROM news";
                    $stmt = $con->query($sql);
                    $row_data = $stmt->fetch();
                    $totalpost = array_shift($row_data);
                    $postpagination = $totalpost/5;
                    $postpagination = floor($postpagination);
                    for ($i=1; $i <= $postpagination; $i++) {
                        if (isset($Page)){
                            if ($i==$Page) { ?>
                                <li class="page-item active">
                                    <a href="news.php?page=<?php echo $id; ?>" class="page-link"><?php echo $id; ?></a>
                                </li>
                                <?php
                            }
                            else{
                                ?>
                                <li class="page-item">
                                    <a href="news.php?page=<?php echo $id; ?>" class="page-link"><?php echo $id; ?></a>
                                </li>
                            <?php   }}}
                    ?>
                    <!-- Creating Start Forwad Button -->
                    <?php if (isset($Page)&&!empty($Page)) {
                        if ($Page+1<=$postpagination) {

                            ?>
                            <li class="page-item">
                                <a href="news.php?page=<?php echo $Page+1; ?>" class="page-link">&raquo;</a>
                            </li>
                        <?php } } ?>
                    <!-- Creating End Forward Button -->
                </ul>
            </nav>
            <!-- Pagination Ends -->
        </div>
        <!---Main Area End-->
        <!---Side Area Start-->
        <div class="col-sm-4" style="margin-top:2px;">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h2 class="lead">Recent Post</h2>
                </div>
                <div class="card-body">
                    <?php
                    global $conDB;
                    $sql = "SELECT * FROM news WHERE status='Active' ORDER BY id desc LIMIT 0,5";
                    $stmt = $con->query($sql);
                    while ($row = $stmt->fetch()) {
                        $title = $row['title'];
                        $id = $row['id'];
                        $category = $row['category'];
                        $image = $row['image'];
                        $news = $row['news'];
                        $datetime = $row['datetime'];
                        ?>
                        <div class="media">
                            <img src="../admin/news/<?php echo $image; ?>" class="d-block img-fluid align-self-start" width="90px" height="90px" alt="" srcset="">
                            <div class="media-body ml-2">
                                <a href="FullPost.php?id=<?php echo htmlentities($id);?>" target="_blank"><h6 class="lead"><?php echo htmlentities($title);?></h6></a>
                                <p class="small"><?php echo htmlentities($datetime); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
            </div>
       </div>
</div>
    </section>
</div>
<!-- Main Area End -->
<?php
include 'include/footer.php';
?>