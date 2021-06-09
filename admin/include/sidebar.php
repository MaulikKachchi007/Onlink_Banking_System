<?php
include_once 'DB.php';
include_once 'function.php';
include_once 'session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['id'];
global $con;
$sql = "SELECT * FROM employees_master WHERE id='$get_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $photo = $row['photo'];
}
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="image/avtar.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8; background-color:white;">
        <span class="brand-text font-weight-light">OctoPrime E-Banking</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="image/<?php echo $photo;?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="employee_profile.php" class="d-block"><?= $_SESSION['ename']; ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link has-treeview">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Manage Accounts
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="view_account.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Account Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view_loan_type.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Loan Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view_deposite.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Fixed Deposite</p>
                            </a>
                        </li>
                    </ul>
                </li>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link has-treeview">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Manage Customers
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="view_customers_accounts.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>View Accounts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="customers_detail.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Customers Details</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view_fd_accounts.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Fixed Deposite</p>
                            </a>
                        </li>
                    </ul>
                </li>
                </li>
                <li class="nav-item">
                    <a href="view_news.php" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                         <p>
                            News Management
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon  fas fa-credit-card"></i>
                        <p>
                            Card Management
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="view_cards_type.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>View cards</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pending_card_request.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Pending Card Request</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link  has-treeview">
                        <i class="nav-icon  fas fa-th"></i>
                        <p>
                            Loan Management
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="view_loan_pending.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Pending Loan Requests</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view_loan_account.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Manage Loan Accounts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view_loan_payment.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Manage Loan Payment</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="view_customers_feedback.php" class="nav-link">
                        <i class="fas fa-comments"></i>
                        <p>
                            Manage Feedback
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_employee.php" class="nav-link">
                        <i class="fas fa-user-plus nav-icon"></i>
                        <p>
                            Manage Employees
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link has-treeview">
                        <i class="nav-icon fas fa-file-pdf"></i>
                        <p>
                            Reports
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="custom_reports.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Transaction Reports</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="custom_accounts_reports.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Customers Accounts Reports</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="custom_loan_account_reports.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Loan Accounts Reports</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="custom_fd_reports.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>FD Reports</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="custom_employees_reports.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Employees Reports</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="view_branch.php" class="nav-link">
                        <i class="nav-icon  fas fa-th"></i>
                        <p>
                            Manage Branch
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_message.php" class="nav-link">
                        <i class="nav-icon  fas fa-envelope"></i>
                        <p>
                            Message
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

