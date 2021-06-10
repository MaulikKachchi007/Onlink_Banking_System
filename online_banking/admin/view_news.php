<?php
require_once 'include/DB.php';
require_once 'include/function.php';
require_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
?>
<?php
include_once 'include/header.php';
include_once 'include/topbar.php';
include_once 'include/sidebar.php';
?>
<link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<div class="content-wrapper">
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card card-default mt-2">
                        <div class="card-header">
                            <div class="card-title"><h1 class="text-dark">News Details</h1>
                                <p class="text-muted">Views News Records</p>
                            </div>
                            <div class="pull-right" style="text-align: right;">
                                <a href="add_news.php" class="btn btn-info"><i class="fas fa-plus"></i> Add News</a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xl-12">
                                <div class="container p-1">
                                    <?php
                                    echo ErrorMessage();
                                    echo SuccessMessage();
                                    ?>
                                </div>
                                <table id="example1" class="table table-bordered table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>News</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    global $con;
                                    $get_id = $_SESSION['id'];
                                    $sql = "SELECT * FROM news";
                                    $stmt = $con->query($sql);
                                    $result = $stmt->rowCount();
                                    if ($result > 0)
                                    {
                                        while ($row = $stmt->fetch()) {
                                            $title = $row['title'];
                                            $id = $row['id'];
                                            $category = $row['category'];
                                            $image = $row['image'];
                                            $news = $row['news'];
                                            $status = $row['status'];
                                            ?>
                                            <tr>
                                                <td><?php echo $id;?></td>
                                                <td><?php echo $title; ?> </td>
                                                <td><?php echo $category; ?></td>
                                                <td><img src="news/<?php echo $image;?>" width="120px" height="50px"></td>
                                                <td><?php echo substr($news,0,50);?></td>
                                                <td>
                                                    <?php
                                                    if($status == "Active") {
                                                        echo "<div class='badge badge-success'>".$status.'</div>';
                                                    }
                                                    elseif($status == "Inactive"){
                                                        echo "<div class='badge badge-danger'>".$status.'</div>';
                                                    }?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="delete_news.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure Delete Account.');" class="dropdown-item"> Delete</a></li>
                                                            <li><a href="update_news.php?id=<?php echo $id; ?>" class="dropdown-item"> Update</a></li>
                                                            <li><a  class="dropdown-item" data-toggle="modal"  data-target="#ExampleModal<?php echo $id; ?>">View</a></li>
                                                            <li>
                                                                <?php if ($status == "active") {
                                                                    ?>
                                                                    <a href="change_news_status.php?id=<?php echo $id; ?>"  class="dropdown-item">Inactive</a>
                                                                    <?php
                                                                }
                                                                else{
                                                                    ?>
                                                                    <a href="change_news_status.php?id=<?php echo $id; ?>"  class="dropdown-item">Active</a>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="modal fade" id="ExampleModal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">View News Post</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div  class="modal-body">
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
                                                                    </table>


                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    }else {
                                        $_SESSION['error_message']= "Record not found.";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
</div>
</section>
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<?php
include 'include/footer.php';
?>
<script>
    $(function () {
        $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
    });
</script>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>