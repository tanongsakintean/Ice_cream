<?php
session_start();

include "layouts/header.php";

if (isset($_REQUEST['s'])) {
  session_destroy();
  echo " <script> ";
  echo " window.location.replace('index.php');";
  echo " </script> ";
}

if (isset($_SESSION['ses_id']) == session_id()) {
  if ($_SESSION['ses_status'] == 2) {

    include "admin/admin.php";
  } else if ($_SESSION['ses_status'] == 1) {
    include "custommer/custommer.php";
  } else if ($_SESSION['ses_status'] == 3) {
    include "admin/admin.php";
  } else {
    echo " <script> ";
    echo " window.location.replace('index.php');";
    echo " </script> ";
  }
} else {
  include "custommer/custommer.php";
}


include "layouts/footer.php";
?>


</body>

</html>