<aside class="main-sidebar bg-white ">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link text-center h-16 border-r-2 border-white" style="background-color: #E10617;">
        <div class="inline-block bg-white   rounded-full">
            <i class="  p-2  text-blue-500 fas fa-ice-cream"></i>
        </div>
        <h1 class="ml-3text-bold inline-block text-lg text-white">ICECREAM</h1>
    </a>

    <!-- Sidebar -->
    <div class="sidebar ">


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->


                <?php
                if ($_SESSION['ses_status'] == 2) {
                } else if ($_SESSION['ses_status'] == 3) {
                ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon text-xl fas fa-user text-blue "></i>

                            <p class="text-center pl-4 font-bold">จัดการสมาชิก</p>
                            <i class="right fas fa-angle-left text-lg"></i>

                        </a>
                        <ul class="nav nav-treeview  ">
                            <li class="nav-item  ">
                                <a href="index.php?p=custommer" class="nav-link text-center font-bold">
                                    <p>ผู้ใช้งานลูกค้า</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="index.php?p=sale" class="nav-link text-center font-bold">
                                    <p>ผู้ใช้งานพนักงาน</p>
                                </a>
                            </li>


                        </ul>
                    </li>
                <?php } ?>

                <li class="nav-item">
                    <a href="index.php?p=product" class="nav-link">
                        <i class="fas fa-box text-xl text-yellow-500"></i>

                        <p class="text-center pl-4 text-bold ">จัดการสินค้า</p>
                        <i class="right fas fa-angle-left text-lg"></i>

                    </a>

                </li>


                <li class="nav-item">
                    <a href="index.php?p=promotion" class="nav-link">
                        <i class="fas fa-tag text-xl " style="color: #E10617;"></i>

                        <p class="text-center pl-4 text-bold">จัดการโปรโมชั่น</p>
                        <i class="right fas fa-angle-left text-lg"></i>

                    </a>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cart-plus text-xl text-green-500"></i>
                        <p class="text-center pl-4  font-bold">จัดการออเดอร์</p>
                        <i class="right fas fa-angle-left text-lg"></i>

                    </a>
                    <ul class="nav nav-treeview ">
                        <li class="nav-item  ">
                            <a href="index.php?p=add_order" class="nav-link text-center font-bold">
                                <p>เพิ่มออเดอร์</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?p=get_order" class="nav-link text-center font-bold">
                                <p>ออเดอร์เข้า</p>
                            </a>
                        </li>


                    </ul>
                </li>


                <li class="nav-item">
                    <a href="index.php?p=bill" class="nav-link">
                        <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                        <p class="text-center pl-4  font-bold">สรุปยอดขาย</p>
                        <i class="right fas fa-angle-left text-lg"></i>

                    </a>

                </li>




            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>