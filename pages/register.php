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
            <form action="../action/user_db.php?ac=reg" method="POST" class="md:w-96 w-64   sm:w-72" onSubmit="return ajaxSubmit(this)">
                <div class="mt-3 w-full ">
                    <h1 class="text-xl font-bold text-center ">ลงทะเบียนสมัครสมาชิก</h1>
                </div>
                <div class="mt-3">
                    <h1 class="text-lg text-gray-500">ข้อมูลส่วนตัว*</h1>
                </div>
                <div class="mt-3 flex  w-full  ">
                    <div class="w-full mr-2">
                        <select name="mem_title" class="p-2 w-full   outline-none border-2 border-gray-100 shadow-md rounded-md" required>
                            <option value="" hidden disabled selected>คำนำหน้า</option>
                            <option value="1">นาย</option>
                            <option value="2">นาง</option>
                            <option value="3">นางสาว</option>
                        </select>
                    </div>
                    <div class="w-full ml-2">
                        <select name="mem_gender" id="" class="p-2 w-full  outline-none border-2 border-gray-100 shadow-md rounded-md" required>
                            <option value="" hidden disabled selected>เพศ</option>
                            <option value="1">ชาย</option>
                            <option value="2">หญิง</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3  w-full  ">
                    <input type="text" name="mem_firstname" id="mem_firstname" class="p-1 border-2 text-gray-500 border-gray-100 bg-white w-full  rounded-md  outline-none shadow-md  " placeholder="ชื่อ*" autofocus>
                </div>
                <div class="mt-3  w-full  ">
                    <input type="text" name="mem_lastname" id="mem_lastname" class="p-1 border-2 text-gray-500 border-gray-100 bg-white w-full  rounded-md  outline-none shadow-md  " placeholder="นามสกุล*">
                </div>

                <div class="mt-3  w-full  ">
                    <input type="text" name="mem_phone" id="mem_phone" class="p-1 border-2 text-gray-500 border-gray-100 bg-white w-full  rounded-md  outline-none shadow-md  " maxlength="10" placeholder="เบอร์โทร*">
                </div>
                <div class=" pt-2 w-full">
                    <input type="email" name="mem_username" id="mem_username" class="p-1 text-gray-500 border-2 border-gray-100 bg-white w-full  rounded-md  outline-none shadow-md  " placeholder="อีเมล*">
                </div>
                <div class=" pt-2 w-full">
                    <input type="password" id="password1" class="p-1 text-gray-500 border-2 border-gray-100 bg-white w-full  rounded-md  outline-none shadow-md  " placeholder="รหัสผ่าน*">
                </div>
                <div class=" pt-2 w-full">
                    <input type="password" name="mem_password" id="password2" class="p-1 text-gray-500 border-2 border-gray-100 bg-white w-full  rounded-md  outline-none shadow-md  " placeholder="ยืนยันรหัสผ่าน*">
                </div>

                <div class="flex justify-center  mt-5 items-end ">
                    <button class="p-2 w-full bg-red-500 hover:bg-red-600  md:text-lg text-xs   sm:text-sm  font-bold text-white rounded-md " type="submit">สมัครสมาชิก</button>
                </div>

            </form>
        </div>
    </div>


    <script>

    </script>


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
        if ($('#mem_firstname').val() == '') {
            $('#mem_firstname').focus();
        } else if ($('#mem_lastname').val() == '') {
            $('#mem_lastname').focus();
        } else if ($('#mem_phone').val() == '') {
            $('#mem_phone').focus();
        } else if ($('#mem_username').val() == '') {
            $('#mem_username').focus();
        } else if ($('#password1').val() == '') {
            $('#password1').focus();
        } else if ($('#password2').val() == '') {
            $('#password2').focus();
        } else if ($('#password1').val() != $('#password2').val()) {

            swal.fire({
                title: 'รหัสไม่ตรงกัน',
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1000
            })
            $('#password2').focus();
        } else {
            var url = $(formEl).attr('action');
            var data = $(formEl).serialize();

            $.ajax({
                type: "POST",
                url: url,
                data: data,
                datatype: 'html',
                success: function(data) {
                    if (data == 0) {
                        swal.fire({
                            title: 'อีเมลนี้มีในระบบแล้ว!',
                            icon: 'error',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else if (data == 1) {
                        window.location.replace("../index.php");
                    }
                }
            });
        }
        return false;
    }
</script>