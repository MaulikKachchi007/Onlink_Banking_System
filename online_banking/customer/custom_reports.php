<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['c_id'];
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
                            <div class="card-title"><h1 class="text-dark">View Statement Reports</h1>
                                <p class="text-muted">Views Statement Reports</p>
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
                                    <div class="alert alert-danger alert-dismissible fade show d-none"  role="alert">
                                        All Field Required!
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>"  method="post">
                                        <div class="form-group">
                                            <label for="statement">Select Days</label>
                                            <select name="statement" id="statement"class="form-control"  onchange="loadcustomer(this.value)">
                                                <option value="Select" selected>Select</option>
                                                <option value="week">Weekly Statement</option>
                                                <option value="month">Monthly Statement</option>
                                                <option value="year">Yearly Statement</option>
                                                <option value="custom">Custom Statement</option>
                                            </select>
                                        </div>
                                    <div id="customer_loading"><img src="image/LoadingSmall.gif" width="172" height="172" /></div>
                                    </div>
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
    function loadcustomer(statement) {
        if(window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
        }else{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status==200){
                document.getElementById('customer_loading').innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxcustomreport.php?statement="+statement,true);
        xmlhttp.send();
    }
    function load_report(fromDate,toDate) {
        if(window.XMLHttpRequest){
            xmlhttp = new XMLHttpRequest();
        }else{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status==200){
                document.getElementById('report_load').innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","ajaxloadcustomreport.php?fromDate="+fromDate+"&toDate="+toDate,true);
        xmlhttp.send();
    }
</script>
<script src="assets/dist/js/custom.js"></script>
<script>
    $(function () {
        $('#example1').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
        });
    });
</script>
<script src="assets/chart.js/Chart.min.js"></script>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
