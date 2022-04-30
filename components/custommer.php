<?php
if (isset($_SESSION['ses_status'])) {
    if ($_SESSION['ses_status'] != 2 && $_SESSION['ses_status'] != 3) {
        echo "<script>window.location.reload()</script>";
    }
}

include("class/MangeUserClass.php");
$meu = new MangeUserClass();

if (isset($_REQUEST['ac']) == "sec") {
    if ($_REQUEST['keyword'] != '') {
        $val = $meu->qty("SELECT * FROM tb_member WHERE tb_member.mem_status = 1 AND (tb_member.mem_username LIKE '%" . $_REQUEST['keyword'] . "%' OR tb_member.mem_firstname LIKE '%" . $_REQUEST['keyword'] . "%' OR tb_member.mem_lastname LIKE '%" . $_REQUEST['keyword'] . "%' OR tb_member.mem_phone LIKE '%" . $_REQUEST['keyword'] . "%')  ");
    } else {
        $val = $meu->qty("SELECT * FROM tb_member WHERE mem_status = 1");
    }
} else {
    $val = $meu->qty("SELECT * FROM tb_member WHERE mem_status = 1");
}

?>
<div class="container-fluid  p-5 bg-white">
    <div>
        <button data-toggle="modal" data-target="#addmodal" class="text-white text-lg  px-3 py-2 rounded-md bg-green-500 hover:bg-green-600 "><i class="fas fa-plus text-white"></i> เพิ่มข้อมูลลูกค้า</button>
    </div>
    <div class="  mt-4 h-2 " style="background-color: #ECF2F5;"></div>
    <div class="my-4">
        <form action="?p=custommer&ac=sec" method="post">

            <div class="mt-4 mb-3 ">
                <h1 class="text-lg ">ค้นหาลูกค้า</h1>
            </div>
            <div class="my-3">
                <input type="text" name="keyword" class="bg-white  pl-2 py-1 text-lg outline-none  rounded-md shadow-md w-full border-2 border-gray-200" style="border: 2px soild #F7F9F9;">
                <p class="my-3 text-lg ">กรอกคำค้นที่ต้องการ เช่น อีเมลล์ ชื่อ นามสกุล เบอร์โทร</p>
            </div>
            <div class="flex justify-end ">
                <button type="submit" class="bg-purple-500 text-lg px-3 py-2 text-white rounded-lg hover:bg-purple-600">ค้นหาข้อมูล</button>
            </div>
        </form>
    </div>
    <div>
        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>อีเมล</th>
                    <th>เพศ</th>
                    <th>เบอร์โทร</th>
                    <th>คะแนน</th>
                    <th>เข้าสู่ระบบล่าสุด</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $i = 1;
                while ($get = $val->fetch_object()) {

                    if ($get->mem_title == 1) $fname = "นาย " . $get->mem_firstname . " " . $get->mem_lastname;
                    else if ($get->mem_title == 2) $fname = "นาง " . $get->mem_firstname . " " . $get->mem_lastname;
                    else if ($get->mem_title == 3) $fname = "นางสาว " . $get->mem_firstname . " " . $get->mem_lastname;

                    if ($get->mem_gender == 1) $gender = "ชาย";
                    else if ($get->mem_gender == 2) $gender = "หญิง";
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $fname;  ?></td>
                        <td><?php echo $get->mem_username; ?></td>
                        <td><?php echo $gender; ?></td>
                        <td><?php echo substr($get->mem_phone, 0, 3) . "-" . substr($get->mem_phone, 3, 3) . "-" . substr($get->mem_phone, 6, 4); ?></td>
                        <td><?php echo  number_format($get->mem_point); ?></td>
                        <td><?php echo date('d/m/', strtotime($get->last_login)) . substr($get->last_login, 0, 4) + 543 . " " . date('H:s', strtotime($get->last_login)) ?></td>
                        <td>
                            <div class="flex justify-around">
                                <i onClick="edit(<?php echo $get->mem_id; ?>)" data-toggle="modal" data-target="#editmodal" class="fas fa-edit text-lg text-yellow-500 cursor-pointer"></i>
                                <i onClick="del(<?php echo $get->mem_id; ?>)" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer"></i>
                            </div>
                        </td>
                    </tr>
                <?php $i++;
                } ?>
            </tbody>

        </table>
    </div>


    <!-- Modal addcustommer -->
    <div class="modal fade bd-example-modal-lg" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="text-xl " id="exampleModalLongTitle">เพิ่มข้อมูลลูกค้า</h5>
                    <i data-dismiss="modal" aria-label="Close" class="cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>
                </div>
                <form action="action/user_db.php?ac=new_cus" method="POST" enctype="multipart/form-data" onSubmit="return ajaxSubmit(this)">
                    <div class="modal-body">
                        <div class="w-full">
                            <div class="flex py-2 ">
                                <div class="flex justify-start">
                                    <div class="mx-3">
                                        <h1 class=" text-lg py-2">คำนำหน้า</h1>
                                        <div class="flex">
                                            <div class="mx-3 ">
                                                <input type="radio" id="javascript" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_title" value="1" required>
                                                <label class="text-lg">
                                                    นาย
                                                </label>
                                            </div>
                                            <div class="mx-3">
                                                <input type="radio" id="javascript" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_title" value="2" required>
                                                <label class="text-lg">
                                                    นาง
                                                </label>
                                            </div>
                                            <div class="mx-3">
                                                <input type="radio" id="javascript" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_title" value="3" required>
                                                <label class="text-lg">
                                                    นางสาว
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-start">
                                    <div class="ml-12">
                                        <h1 class="text-lg py-2">เพศ</h1>
                                        <div class="flex  w-full">
                                            <div class="mx-3">
                                                <input type="radio" id="javascript" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_gender" value="1" required>
                                                <label class="text-lg">
                                                    ชาย
                                                </label>
                                            </div>
                                            <div class="mx-3">
                                                <input type="radio" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_gender" value="2" required>
                                                <label class="text-lg">
                                                    หญิง
                                                </label>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ชื่อ</h1>
                                        <input type="text" id="mem_firstname" name="mem_firstname" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกชื่อ" id="">
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">นามสกุล</h1>
                                        <input type="text" id="mem_lastname" name="mem_lastname" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกนามสกุล" id="">
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">เบอร์โทรศัพท์</h1>
                                        <input maxlength="10" id="mem_phone" type="tel" name="mem_phone" placeholder="กรอกเบอร์โทร" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="">
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">อีเมล</h1>
                                        <input type="email" id="mem_username" name="mem_username" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกอีเมล" id="">
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">รหัสผ่าน</h1>
                                        <input type="password" id="password1" placeholder="กรอกรหัสผ่าน" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="">
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ยืนยันรหัสผ่าน</h1>
                                        <input type="password" id="password2" name="mem_password" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="ยืนยันรหัสผ่านอีกครั้ง" id="">
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>

                    <div class="modal-footer py-4">
                        <button type="submit" class="text-lg py-2 px-3 text-white bg-purple-500 hover:bg-purple-600 rounded-md">เพิ่มข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Editcustommer -->
    <div class="modal fade bd-example-modal-lg" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="text-xl ">แก้ไขข้อมูลลูกค้า</h5>
                    <i data-dismiss="modal" aria-label="Close" class="cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>
                </div>
                <form id="action" method="POST" onSubmit="return ajaxEdit(this)">
                    <div class="modal-body">
                        <div class="w-full">
                            <div class="flex py-2 ">
                                <div class="flex justify-start">
                                    <div class="mx-3">
                                        <h1 class=" text-lg py-2">คำนำหน้า</h1>
                                        <div class="flex">
                                            <div class="mx-3 ">
                                                <input type="radio" id="edit_title1" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_title" value="1">
                                                <label class="text-lg">
                                                    นาย
                                                </label>
                                            </div>
                                            <div class="mx-3">
                                                <input type="radio" id="edit_title2" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_title" value="2">
                                                <label class="text-lg">
                                                    นาง
                                                </label>
                                            </div>
                                            <div class="mx-3">
                                                <input type="radio" id="edit_title3" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_title" value="3">
                                                <label class="text-lg">
                                                    นางสาว
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-start">
                                    <div class="ml-12">
                                        <h1 class="text-lg py-2">เพศ</h1>
                                        <div class="flex  w-full">
                                            <div class="mx-3">
                                                <input type="radio" id="edit_gender1" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_gender" value="1">
                                                <label class="text-lg">
                                                    ชาย
                                                </label>
                                            </div>
                                            <div class="mx-3">
                                                <input type="radio" id="edit_gender2" class=" border-gray-200 focus:outline-none transition duration-200 mt-1   float-left mr-2 cursor-pointer rounded-full h-5 w-5" name="mem_gender" value="2">
                                                <label class="text-lg">
                                                    หญิง
                                                </label>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ชื่อ</h1>
                                        <input type="text" id="edit_firstname" name="mem_firstname" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกชื่อ" id="">
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">นามสกุล</h1>
                                        <input type="text" id="edit_lastname" name="mem_lastname" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกนามสกุล" id="">
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">เบอร์โทรศัพท์</h1>
                                        <input maxlength="10" id="edit_phone" type="tel" name="mem_phone" placeholder="กรอกเบอร์โทร" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="">
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">อีเมล</h1>
                                        <input type="email" id="edit_username" name="mem_username" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกอีเมล" id="">
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">รหัสผ่าน</h1>
                                        <input type="password" id="edit_password1" name="" placeholder="กรอกรหัสผ่าน" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3">
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ยืนยันรหัสผ่าน</h1>
                                        <input type="password" id="edit_password2" name="mem_password" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="ยืนยันรหัสผ่านอีกครั้ง">
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>

                    <div class="modal-footer py-4">
                        <button type="submit" class="text-lg py-2 px-3 text-white bg-yellow-500 hover:bg-yellow-600 rounded-md">แก้ไขข้อมูล</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="js/custommer.js">

</script>