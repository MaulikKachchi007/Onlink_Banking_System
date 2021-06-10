<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['id'];
global $con;
$sql = "SELECT * FROM employees_master where id='$get_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()){
    $ifsccode = $row['ifsccode'];
}

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
                            <div class="card-title"><h1 class="text-dark">View Income Expence Reports</h1>
                                <p class="text-muted">Views Income Expence Reports</p>
                            </div>
                            <div class="pull-right" style="text-align: right;">
                                <a href="export_report_pdf.php" class="btn btn-info"><i class="fas fa-file-pdf"></i>  Export PDF</a>
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
                                    <div class="form-group">
                                        <label for="fromDate">From</label>
                                        <input class="form-control" type="date" id="fromDate" name="fromDate">
                                    </div>
                                    <div class="form-group">
                                        <label for="toDate">To</label>
                                        <input class="form-control" type="date" id="toDate" name="toDate">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary" onclick="showreports(fromDate.value, toDate.value)" name="submit" value="Search">
                                    </div>
                                <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post">

                                    <div id="reports_loading"><img src="image/LoadingSmall.gif" width="172" height="172" /></div>
                                </form>
                            </div
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
    function showreports(fromdate, todate) {
        if(window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
        }else{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status==200){
                document.getElementById('reports_loading').innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxincomeexpennsereport.php?fromdate="+fromdate+"&todate="+todate,true);
        xmlhttp.send();
    }
</script>
<script src="assets/dist/js/custom.js"></script>