<?php
include_once 'DB.php';
include_once 'function.php';
include_once 'session.php';
$_SESSION['TrackingURL'] = $_SERVER['PHP_SELF'];
confirm_login();
$get_id = $_SESSION['c_id'];
global $con;
$sql = "SELECT * FROM customers_master WHERE c_id='$get_id'";
$stmt = $con->query($sql);
while ($row = $stmt->fetch()) {
    $photo = $row['photo'];
}
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <img src="image/avtar.png"   alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8;background-color: white;">
        <span class="brand-text font-weight-light">Octo Prime E-Banking</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="customer image/<?php echo $photo;?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="profile.php" class="d-block"><?php echo $_SESSION['f_name']; ?></a>
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
                            Accounts
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="view_bank_accounts.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Manage Accounts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="change_pin_password.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Manage Pin Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="View_transaction.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Manage Transaction</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="view_loan_payment.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Manage Loan Payments</p>
                            </a>
                        </li>
                    </ul>
                </li>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link has-treeview">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Fund Transfer
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="fund_transfer.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Transfer Fund</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="registeredpayee.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Add Registered Payee</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="viewcustregisteredpayee.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>View Registered Payee</p>
                            </a>
                        </li>
                    </ul>
                </li>
                </li>
                <li class="nav-item">
                    <a href="view_cards.php" class="nav-link">
                        <i class="nav-icon fas fa-newspaper"></i>
                         <p>
                            Cards
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_fd_account.php" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            FD Accounts
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="view_loan_accounts.php" class="nav-link">
                        <i class="nav-icon  fas fa-credit-card"></i>
                        <p>
                            Loans
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link  has-treeview">
                        <i class="nav-icon  fas fa-th"></i>
                        <p>
                            Payment
                        </p>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="make_loan_payment.php" class="nav-link">
                                <i class="fas fa-minus nav-icon"></i>
                                <p>Make Loan Payment</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="custom_reports.php" class="nav-link">
                        <i class="nav-icon  fas fa-file-pdf"></i>
                        <p>
                            Reports
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

