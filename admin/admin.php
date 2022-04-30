<body class="hold-transition sidebar-mini  layout-fixed">

    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

    <div class="wrapper " style="background-color: #F2F7FF;">


        <!-- Navbar -->
        <?php



        include "layouts/navbar.php";
        include "layouts/sidebar.php";

        ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper  h-screen ">
            <section class="content mt-2" style="background-color: #F2F7FF;">

                <?php

                if (isset($_REQUEST['p'])) {
                    require_once("components/" . $_REQUEST['p'] . ".php");
                } else {
                    require_once("components/default.php");
                }

                ?>
            </section>
        </div>
        <!-- /.content-wrapper -->
        <!-- <footer class="main-footer">
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.1.0
        </div>
    </footer> -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->