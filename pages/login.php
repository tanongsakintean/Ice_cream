<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ice-cream</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- sweetalert--->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11""></script>
    <script src=" https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="container-xl bg-gray-100 flex justify-center items-center h-screen">
        <div class="p-10  shadow-md border-none outline-none  bg-white rounded-xl">
            <form action="../action/user_db.php?ac=log" method="POST" class="md:w-96 w-64   sm:w-72" onSubmit="return ajaxSubmit(this)">
                <div class=" flex justify-center  items-center ">
                    <i class="fas fa-user-circle text-blue-500   " style="font-size: 7rem;"></i>
                </div>
                <div class="mt-3  w-full  ">
                    <input type="email" name="mem_username" id="inputEmail" class="p-1 border-2 text-gray-500 border-gray-100 bg-white w-full  rounded-md  outline-none shadow-md  " placeholder="อีเมล*" required autofocus>
                </div>
                <div class=" pt-2 w-full">
                    <input type="password" name="mem_password" id="inputPassword" class="p-1 text-gray-500 border-2 border-gray-100 bg-white w-full  rounded-md  outline-none shadow-md  " placeholder="รหัสผ่าน*" required>
                </div>

                <div class="flex justify-center  mt-5 items-end ">
                    <button class="p-2 w-full bg-sky-500 hover:bg-sky-600  md:text-lg text-xs   sm:text-sm  font-bold text-white rounded-md " type="submit">ลงชื่อเข้าใช้งาน</button>
                </div>
                <div class="mt-5 ">
                    <p class="text-gray-500 md:text-lg text-xs   sm:text-sm font-bold">ยังไม่ได้เป็นสมาชิกคลิกเลย > <a href="register.php" class="text-red-500 hover:underline hover:underline-offset-1 sm:text-sm md:text-lg  font-bold">สมัครสมาชิกใหม่</a></p>
                    <a href="forgotpassword.php" class="text-red-500 text-xs md:text-lg sm:text-sm font-bold hover:underline hover:underline-offset-1 ">แจ้งลืมรหัสผ่าน ?</a>
                </div>
            </form>
        </div>
    </div>



    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>



<script type="text/javascript">
    var ajaxSubmit = function(formEl) {
        if ($('#mem_username').val() == '') {
            $('#mem_username').focus();
        } else if ($('#mem_password').val() == '') {
            $('#mem_password').focus();
        } else {
            var url = $(formEl).attr('action');
            var data = $(formEl).serialize();
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                datatype: 'html',
                success: function(data) {
                    if (data == 1) {
                        window.location.replace("../index.php");
                    } else if (data == 0) {
                        swal.fire({
                            title: 'อีเมลหรือรหัสผ่านผิด!!',
                            icon: 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
        }
        return false;
    }
</script>