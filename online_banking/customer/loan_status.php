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
                            <div class="card-title"><h1 class="text-dark">View Loan Status</h1>
                                <p class="text-muted">Views Loan Status</p>
                            </div>
                            <div class="pull-right" style="text-align: right;">
                                <a href="customer_loan.php" class="btn btn-info"><i class="fas fa-plus"></i> Apply For Loan</a>
                                <a href="view_loan_accounts.php" id="search_text" class="btn btn-info"><i class="fas fa-reply"></i> View Loan Accounts</a>
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
                                <form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" class="d-flex" method="post">
                                            <div class="input-group">
                                                <input class="form-control" type="text" id="tracknumber"  name="loan_app_number" placeholder="Loan Application Number">
                                                <button type="button" id="trackbtn" class="btn btn-success" name="track_status">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                </form>
                            </div>
                             <div class="col-md-8 offset-md-2">
                                 <div class="table_data">
                                 </div>
                                 <div class="text-center" id="loading_data">
                                     <img src="image/LoadingSmall.gif" style="background-position: center;" width="172" height="172" />
                                 </div>
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
    $(document).ready(function(){
        $('#loading_data').hide();
        $('#trackbtn').click(async function(e){
            if($('#tracknumber').val()){
                $.ajax({
                    data: {loan_app_number:$('#tracknumber').val()},
                    method:'POST',
                    url:'ajaxloanstatus.php',
                    success: function(data){
                        console.log(data);
                        if(data.match('Record Not Found')){
                            console.log(data);
                        }else {
                            setTimeout(function () {
                                $('#loading_data').hide();
                                $('.table_data').html(data);
                            }, 1000);
                        }
                    },
                    beforeSend: function(){
                        $('#loading_data').show();
                    }
                })
            }else{
                $('.alert-danger ').removeClass('d-none');
            }
        })
    })
</script>
<script src="assets/dist/js/custom.js"></script>