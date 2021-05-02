<?php
include_once 'include/DB.php';
include_once 'include/function.php';
include_once 'include/session.php';
$get_id = $_SESSION['id'];
global $con;
$get_id = $_SESSION['id'];
$q = "SELECT * FROM employees_master WHERE id='$get_id'";
$stmt = $con->query($q);
$result = $stmt->execute();
if ($row = $stmt->fetch()){
    $photo = $row['photo'];
}
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="news.php" class="nav-link">News</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="Contact.php" class="nav-link">Contact</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <div class="user-info-dropdown dropdown-menu-right">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
						<span class="user-icon">
							<img src="image/<?php echo $photo;?>" class="direct-chat-img" alt="">
						</span>
                    <span class="text-muted text-center" style="vertical-align: middle;"> <?= $_SESSION['ename'] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list m-2">
                    <a class="dropdown-item" href="employee_profile.php"><i class="fas fa-user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="change_password.php"><i class="fas fa-cog"></i> Setting</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i>Log Out</a>
                    <div class="dropdown-divider"></div>
                </div>
            </div>
        </div>
    </ul>
</nav>