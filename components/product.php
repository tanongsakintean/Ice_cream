<?php
if (isset($_SESSION['ses_status'])) {
    if ($_SESSION['ses_status'] != 2 && $_SESSION['ses_status'] != 3) {
        echo "<script>window.location.reload()</script>";
    }
}

include("class/MangeProductClass.php");
$mep = new MangeProductClass();
$get_cate = $mep->qty("SELECT * FROM tb_category");
$cate_data = $mep->qty("SELECT * FROM tb_category");
$get_unit = $mep->qty("SELECT * FROM tb_unit");
$g_cate = $mep->qty("SELECT * FROM tb_category");
$g_unit = $mep->qty("SELECT * FROM tb_unit");
$unit_data = $mep->qty("SELECT * FROM tb_unit");
$get_bank = $mep->qty("SELECT * FROM tb_bank");
$get_pro = $mep->qty("SELECT * FROM tb_product");

if (isset($_REQUEST['ac']) == "sec") {
    if ($_REQUEST['keyword'] != '') {
        $val = $mep->qty("SELECT * FROM tb_product WHERE tb_product.pro_name LIKE '%" . $_REQUEST['keyword'] . "%' OR tb_product.pro_code LIKE '%" . $_REQUEST['keyword'] . "%' OR tb_product.pro_unit_id LIKE '%" . $_REQUEST['keyword'] . "%' OR tb_product.pro_category_id LIKE '%" . $_REQUEST['keyword'] . "%'  ");
    } else {
        $val = $mep->qty("SELECT * FROM tb_product ORDER BY pro_id DESC");
    }
} else if (isset($_REQUEST['ac']) == "cate") {
    echo $_REQUEST['cate_name'];
} else {
    $val = $mep->qty("SELECT * FROM tb_product ORDER BY pro_id DESC");
}
?>
<!-- Main content -->

<div class="container-fluid  p-5 bg-white">
    <div class="flex ">
        <button data-toggle="modal" data-target="#add_product" class="text-white text-lg mx-3  px-3 py-2 rounded-md bg-green-500 hover:bg-green-600 "><i class="fas fa-plus text-white"></i> เพื่มสินค้า</button>
        <button data-toggle="modal" data-target="#add_category" class="text-white text-lg mx-3 px-3 py-2 rounded-md bg-yellow-500 hover:bg-yellow-600 "><i class="fas fa-calendar-week text-white"></i> เพื่มประเภทสินค้า</button>
        <button data-toggle="modal" data-target="#add_unit" class="text-white text-lg mx-3 px-3 py-2 rounded-md bg-blue-500 hover:bg-blue-600 "><i class="fas fa-shapes text-white"></i> เพื่มหน่วยสินค้า</button>
        <button data-toggle="modal" data-target="#add_bank" class="text-white text-lg mx-3 px-3 py-2 rounded-md bg-teal-500 hover:bg-teal-600 "><i class="fas fa-piggy-bank text-white"></i> เพื่มธนาคาร</button>
    </div>
    <div class="  mt-4 h-2 " style="background-color: #ECF2F5;"></div>
    <div class="my-4">
        <form action="?p=product&ac=sec" method="post">

            <div class="mt-4 mb-3 ">
                <h1 class="text-lg ">ค้นหาสินค้า</h1>
            </div>
            <div class="my-3">
                <input type="text" name="keyword" class="bg-white  pl-2 py-1 text-lg outline-none  rounded-md shadow-md w-full border-2 border-gray-200" style="border: 2px soild #F7F9F9;">
                <p class="my-3 text-lg ">กรอกคำค้นที่ต้องการ เช่น ชื่อสินค้า รหัสสินค้า หน่วยสินค้า ประเภทสินค้า </p>
            </div>
            <div class="flex justify-end ">
                <button type="submit" class="bg-purple-500 text-lg px-3 py-2 text-white rounded-lg hover:bg-purple-600">ค้นหาข้อมูล</button>
            </div>
        </form>
    </div>
    <div class="my-4">
        <div class="flex justify-center">
            <div class="row w-full">
                <?php
                while ($get = $val->fetch_object()) {

                ?>
                    <div class="w-64 mx-5 my-5 rounded-xl  outline outline-2 outline-gray-300 overflow-hidden shadow-md p-1">
                        <img class=" w-full" src="images/products/<?php echo $get->pro_img; ?>" alt="Sunset in the mountains">
                        <div class="px-6 py-4">
                            <div class="font-bold text-red-600 text-lg mb-2"><?php echo $get->pro_name; ?></div>
                            <p class="text-gray-700 text-lg font-bold">
                                <?php echo $get->pro_price; ?> บาท
                            </p>
                        </div>
                        <div class="flex p-3 w-full">
                            <button onclick="select_product(<?php echo $get->pro_id; ?>)" data-toggle="modal" data-target="#edit_product" class="text-lg mx-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-3 ">
                                <i class="fas fa-edit text-white "></i>
                                แก้ไข
                            </button>

                            <button onclick="del_product(<?php echo $get->pro_id; ?>)" class="text-lg mx-2 rounded-lg bg-red-500 hover:bg-red-600 text-white py-2 px-3 ">
                                <i class="fas fa-trash-alt text-white"></i>
                                ลบ
                            </button>
                        </div>
                    </div>
                <?php
                } ?>

            </div>
        </div>
    </div>

    <!-- Modal add_product -->
    <div class="modal fade bd-example-modal-lg" id="add_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="text-xl " id="exampleModalLongTitle">เพิ่มสินค้า</h5>
                    <i data-dismiss="modal" aria-label="Close" class=" cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>
                </div>
                <form action="action/product_db.php?ac=add_pro" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="w-full">
                            <div class="flex py-2 ">
                                <div class="flex justify-start">
                                    <div class="mx-3 flex ">
                                        <label class=" cursor-pointer  py-2 px-3 text-white bg-green-500 text-lg rounded-md outline-none border-none hover:bg-green-600">
                                            <input type="file" class="hidden" name="pro_img" id="pro_img" accept="image/*" required><i class="fas fa-plus"></i> เพิ่มรูปภาพ</label>
                                        <h1 id="show_file" class="text-center mx-3 text-md mt-2 font-bold">ยังไม่ได้อัปรูปภาพ</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ชื่อสินค้า</h1>
                                        <input type="text" name="pro_name" id="pro_name" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกชื่อสินค้า" id="" required>
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">รหัสสินค้า</h1>
                                        <input type="text" name="pro_code" id="pro_code" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกรหัสสินค้า" id="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ราคาสินค้า</h1>
                                        <input type="number" name="pro_price" id="pro_price" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกราคาสินค้า" id="" required>
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">หน่วยสินค้า</h1>
                                        <select name="pro_unit_id" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="" required>
                                            <option value="" hidden disable selected>หน่วยสินค้า</option>
                                            <?php while ($get = $unit_data->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $get->unit_name; ?>"><?php echo $get->unit_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-center w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ประเภทสินค้า</h1>
                                        <select name="pro_category_id" class="bg-white text-center w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="" required>
                                            <option value="" hidden disable selected>ประเภทสินค้า</option>
                                            <?php while ($get = $cate_data->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $get->cate_name; ?>"><?php echo $get->cate_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">รายละเอียดสินค้า1</h1>
                                        <textarea name="pro_description1" id="pro_description1" placeholder="กรอกรายละเอียดสินค้า1" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">รายละเอียดสินค้า2</h1>
                                        <textarea name="pro_description2" id="pro_description2" placeholder="กรอกรายละเอียดสินค้า2" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="" cols="30" rows="5"></textarea>
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

    <!-- Modal edit_product -->
    <div class="modal fade bd-example-modal-lg" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="text-xl " id="exampleModalLongTitle">แก้ไขสินค้า</h5>
                    <i data-dismiss="modal" aria-label="Close" class=" cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>
                </div>
                <form action="action/product_db.php?ac=edit_pro" method="POST" enctype="multipart/form-data">
                    <div class=" modal-body">
                        <div class="w-full">
                            <div class="flex py-2 ">
                                <div class="flex justify-start">
                                    <div class="mx-3 flex ">
                                        <label class=" cursor-pointer  py-2 px-3 text-white bg-yellow-500 text-lg rounded-md outline-none border-none hover:bg-yellow-600">
                                            <input type="file" class="hidden" name="edit_pro_img" id="edit_pro_img" accept="image/*"><i class="fas fa-plus"></i> แก้ไขรูปภาพ</label>
                                        <h1 id="edit_show_file" class="text-center mx-3 text-md mt-2 font-bold">ยังไม่ได้อัปรูปภาพ</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ชื่อสินค้า</h1>
                                        <input type="text" name="pro_id" id="pro_id" hidden>
                                        <input type="text" name="edit_pro_name" id="edit_pro_name" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกชื่อสินค้า" id="">
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">รหัสสินค้า</h1>
                                        <input type="text" name="edit_pro_code" id="edit_pro_code" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกรหัสสินค้า" id="">
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ราคาสินค้า</h1>
                                        <input type="number" name="edit_pro_price" id="edit_pro_price" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกราคาสินค้า" id="">
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">หน่วยสินค้า</h1>
                                        <select name="edit_pro_unit" id="edit_pro_unit" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="">

                                            <?php while ($get = $g_unit->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $get->unit_name; ?>"><?php echo $get->unit_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-center w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ประเภทสินค้า</h1>
                                        <select name="edit_pro_cate" id="edit_pro_cate" class="bg-white text-center w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="">
                                            <?php while ($get = $g_cate->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $get->cate_name; ?>"><?php echo $get->cate_name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="flex py-2 w-full">
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">รายละเอียดสินค้า1</h1>
                                        <textarea name="edit_pro_description1" id="edit_pro_description1" placeholder="กรอกรายละเอียดสินค้า1" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="flex justify-start w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">รายละเอียดสินค้า2</h1>
                                        <textarea name="edit_pro_description2" id="edit_pro_description2" placeholder="กรอกรายละเอียดสินค้า2" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" id="" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>


                        </div>


                    </div>

                    <div class="modal-footer py-4">
                        <button type="submit" class="text-lg py-2 px-3 text-white bg-yellow-500 hover:bg-yellow-600 rounded-md">แก้ไขสินค้า</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal add_category -->
    <div class="modal fade bd-example-modal-lg" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="text-xl " id="exampleModalLongTitle">เพิ่มประเภทสินค้า</h5>
                    <i data-dismiss="modal" aria-label="Close" class=" cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>
                </div>
                <form action="action/product_db.php?ac=add_cate" method="post" onSubmit="return ajax_cate(this)">
                    <div class="modal-body">
                        <div class="w-full">

                            <div class="flex py-2 w-full">
                                <div class="flex justify-center w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ประเภทสินค้า</h1>
                                        <input type="text" name="cate_name" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกชื่อประเภทสินค้า" id="cate_name">
                                    </div>
                                </div>
                            </div>

                            <div class=" py-2 px-3 w-full">
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ประเภทสินค้า</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($get = $get_cate->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $get->cate_name; ?></td>
                                                <td>
                                                    <div class="flex justify-around">
                                                        <i onclick="edit_category(<?php echo $get->cate_id; ?>)" data-toggle="modal" data-target="#editmodal" class="fas fa-edit text-lg text-yellow-500 cursor-pointer"></i>
                                                        <i onclick="del_category(<?php echo $get->cate_id; ?>)" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                            $i++;
                                        } ?>

                                    </tbody>

                                </table>
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


    <!-- Modal add_unit -->
    <div class="modal fade bd-example-modal-lg" id="add_unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="text-xl " id="exampleModalLongTitle">เพิ่มหน่วยสินค้า</h5>
                    <i data-dismiss="modal" aria-label="Close" class=" cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>
                </div>
                <form action="action/product_db.php?ac=add_unit" method="post" onSubmit="return ajax_unit(this)">
                    <div class="modal-body">
                        <div class="w-full">

                            <div class="flex py-2 w-full">
                                <div class="flex justify-center w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">หน่วยสินค้า</h1>
                                        <input type="text" name="unit_name" id="unit_name" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกชื่อหน่วยสินค้า" id="">
                                    </div>
                                </div>
                            </div>

                            <div class=" py-2 px-3 w-full">
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>หน่วสินค้า</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($get = $get_unit->fetch_object()) {

                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $get->unit_name; ?></td>
                                                <td>
                                                    <div class="flex justify-around">
                                                        <i onClick="edit_unit(<?php echo $get->unit_id; ?>)" data-toggle="modal" data-target="#editmodal" class="fas fa-edit text-lg text-yellow-500 cursor-pointer"></i>
                                                        <i onClick="del_unit(<?php echo $get->unit_id; ?>)" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++;
                                        } ?>

                                    </tbody>

                                </table>
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

    <!-- Modal add_bank -->
    <div class="modal fade bd-example-modal-lg" id="add_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="text-xl " id="exampleModalLongTitle">เพิ่มธนาคาร</h5>
                    <i data-dismiss="modal" aria-label="Close" class=" cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>
                </div>
                <form action="action/product_db.php?ac=add_bank" method="post" onSubmit="return ajax_bank(this)">
                    <div class="modal-body">
                        <div class="w-full">

                            <div class="flex py-2 w-full">
                                <div class="flex justify-center w-full">
                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ชื่อธนาคาร</h1>
                                        <input type="text" name="bank_name" id="bank_name" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกชื่อธนาคาร" id="">
                                    </div>

                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">ชื่อเจ้าของบัญชี</h1>
                                        <input type="text" name="bank_username" id="bank_username" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกชื่อเจ้าของบัญชี" id="">
                                    </div>

                                    <div class="mx-3 w-full">
                                        <h1 class="text-lg">เลขที่บัญชี</h1>
                                        <input type="text" maxlength="10" name="bank_number" id="bank_number" class="bg-white w-full rounded-lg border-2 py-1 text-lg border-gray-200 outline-none pl-3" placeholder="กรอกเลขที่บัญชี" id="">
                                    </div>

                                </div>
                            </div>

                            <div class=" py-2 px-3 w-full">
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อธนาคาร</th>
                                            <th>ชื่อเจ้าของบัญชี</th>
                                            <th>เลขที่บัญชี</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        while ($get = $get_bank->fetch_object()) {
                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $get->bank_name; ?></td>
                                                <td><?php echo $get->bank_username; ?></td>
                                                <td><?php echo $get->bank_number; ?></td>
                                                <td>
                                                    <div class="flex justify-around">
                                                        <i onclick="edit_bank(<?php echo $get->bank_id; ?>)" data-toggle="modal" data-target="#editmodal" class="fas fa-edit text-lg text-yellow-500 cursor-pointer"></i>
                                                        <i onclick="del_bank(<?php echo $get->bank_id; ?>)" class="fas fa-trash-alt text-lg text-red-500 cursor-pointer"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $i++;
                                        } ?>

                                    </tbody>

                                </table>
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
</div>


<script type="text/javascript" src="js/products.js">
</script>