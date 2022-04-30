<?php
require_once "class/GetDataClass.php";
$db = new GetDataClass();
$order = $db->qty("SELECT COUNT(*) FROM tb_order WHERE pay_status = 0 AND DAY(order_date) = DAY(NOW())")->fetch_array()[0];
?>
<nav class="main-header  top-0 sticky z-10  navbar navbar-expand text-white" style="background-color: #E10617;">
    <!-- Left navbar links -->
    <ul class="navbar-nav">

        <li class="nav-item d-none d-sm-inline-block">
            <a href="index.php" class="nav-link text-lg">Home</a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto flex items-center">




        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link h4" data-toggle="dropdown" href="#">
                <i class="fas fa-bell text-yellow-500 text-xl "></i>
                <span class="badge badge-light navbar-badge text-bold  top-0 left-4  text-xs"><?php echo $order; ?></span> </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <?php
                if ($order > 0) {
                ?>
                    <a href="index.php?p=get_order" class="dropdown-item">
                        ออเดอร์เข้าวันนี้ <?php echo $order; ?> รายการ
                    </a>
                <?php  } ?>

            </div>
        </li>
        <li class="nav-item ">
            <a class="nav-link h4" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt text-xl"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link h4" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large text-xl"></i>
            </a>
        </li>
        <li class="nav-item  ">
            <a href="#" data-toggle="dropdown" class="nav-link h4">
                <i class="fas fa-user-circle text-xl"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">


                <div class="dropdown-divider"></div>
                <a href="index.php?s=log" class="dropdown-item">
                    <i class="fas fa-sign-out-alt text-red-500 mr-2"></i>ออกจากระบบ
                </a>
            </div>
        </li>
    </ul>
</nav>