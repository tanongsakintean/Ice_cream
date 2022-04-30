<body style="background-image: url('https://www.swensens1112.com/assets/images/bg-white.jpg');background-size:cover;">



    <?php
    include("./class/DatabaseClass.php");
    $db = new DatabaseClass();
    require_once("layouts/navbar.php");
    require_once("layouts/sidebar.php");

    if (isset($_REQUEST['p'])) {
        require_once("components/" . $_REQUEST['p'] . ".php");
    } else {
        require_once("components/home.php");
    }
    ?>