<?php

if (isset($_REQUEST['ac']) && $_REQUEST['ac'] == 'newcal') {
    for ($i = 0; $i <= $_SESSION['ses_inline']; $i++) {
        if (isset($_SESSION['ses_amount'][$i]) != "") {
            $_SESSION['ses_amount'][$i] =  $_REQUEST['pro_num'][$i];
        }
    }
} else if (isset($_REQUEST['ac']) && $_REQUEST['ac'] == 'del') {
    unset($_SESSION['ses_cart'][$_REQUEST['line']]);
    unset($_SESSION['ses_amount'][$_REQUEST['line']]);
    //  echo "<script>window.location.replace('index.php?p=order')</script>";
}
?>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {

        -webkit-appearance: none;
        margin: 0;
    }
</style>
<div>
    <div class="pt-4">
        <div class="flex justify-center  items-center">
            <h1 class=" text-red-500 mx-1" style="font-size: 23px;">ตะกร้าสินค้า</h1>
            <?php if (isset($_SESSION['ses_cart'])) { ?>
                <p class="text-gray-500 mx-1 mt-1" style="font-size: 15px;"><?php echo count($_SESSION['ses_cart']); ?> รายการ</p>
            <?php } ?>
        </div>

        <form action="index.php?p=order&ac=newcal" method="post">
            <div class="pl-3 flex justify-center flex-wrap m-0">
                <?php
                $_SESSION['ses_total'] = 0;
                if (isset($_SESSION['ses_inline'])) {
                    for ($i = 0; $i <= $_SESSION['ses_inline']; $i++) {
                        if (isset($_SESSION['ses_amount'][$i]) != "") {
                            $get  =  $db->qty("SELECT * FROM tb_product WHERE pro_id = '" . $_SESSION['ses_cart'][$i] . "'")->fetch_object();
                            $_SESSION['ses_total'] += $get->pro_price * $_SESSION['ses_amount'][$i];

                ?>
                            <div class="my-3 mx-2  py-3 px-2 w-96">
                                <a href="?p=order&ac=del&line=<?php echo $i; ?>">
                                    <i class="fas fa-times-circle text-gray-400 float-right -mt-2 cursor-pointer" style="font-size: 28px;">
                                    </i></a>
                                <div class=" rounded-lg justify-center bg-white  shadow-md py-3 ">
                                    <div class="flex pl-3">
                                        <div class="mr-3 ">
                                            <img style="height: 175px;" src="images/products/<?php echo $get->pro_img; ?>" alt="">
                                        </div>
                                        <div class="mx-1">
                                            <div>
                                                <h1 style="font-size: 20px;" class=" text-black"> <?php echo $get->pro_name; ?> </h1>
                                                <p style="font-size:16px;margin-top:1px;" class="text-gray-400 text-md">1 <?php echo $get->pro_unit_id ?> | <?php echo number_format($get->pro_price); ?> บาท</p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="flex justify-around my-3">

                                        <div class="flex justify-center items-end">
                                            <h1 style="font-size: 20px;" class="ml-4 vals"><?php echo number_format($get->pro_price * $_SESSION['ses_amount'][$i]); ?></h1><span class="mx-1"> <i style="font-size:16px;">บาท</i></span>
                                        </div>
                                        <div>
                                            <i style="color: #E74C3C;font-size:30px;" class=" minus fas fa-minus-circle  cursor-pointer "></i>
                                            <input value="<?php echo $_SESSION['ses_amount'][$i] ?>" name="pro_num[<?php echo $i; ?>]" class="w-24 font-bold -mt-4 text-center shdow-md py-1 border-2 border-gray-300 rounded-xl px-3 outline-none  text-md" type="number" />
                                            <i style="color: #E74C3C;font-size:30px;" class="plus fas fa-plus-circle  cursor-pointer"></i>
                                        </div>
                                    </div>
                                </div>


                            </div>

                <?php

                        }
                    }
                }
                ?>

            </div>
            <?php
            if (isset($_SESSION['ses_cart']) && count($_SESSION['ses_cart']) > 0) {

            ?>
                <div class="flex my-3 justify-center items-center">
                    <h1 class="text-red-500 " style="font-size: 23px;">ราคาสุทธิ <i class="mx-2"><b><?php echo number_format($_SESSION['ses_total']); ?></b> บาท</i></h1>
                </div>

                <div class="my-4 flex justify-center items-center">
                    <button type="submit" class="bg-green-500 mx-2  hover:bg-green-600 py-2 px-3 rounded-md text-white outline-none">คำนวณใหม่</button>
                    <h1 data-toggle="modal" data-target="#payment" class="bg-red-500 mx-2 cursor-pointer hover:bg-red-600 py-2 px-3 rounded-md text-white outline-none">ยืนยันการชำระเงิน</h1>
                </div>
            <?php } ?>

        </form>
    </div>



    <!-- Modal payment -->
    <div class="modal fade bd-example-modal-lg" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header flex justify-between p-4">

                    <i data-dismiss="modal" aria-label="Close" class="cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-arrow-left"></i>
                    <h5 class="text-lg " id="exampleModalLongTitle">ข้อมูลการชำระเงิน</h5>
                    <div></div>
                </div>
                <form action="action/order_db.php?ac=payment" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-0 m-0">
                        <div class="flex mx-3 my-4 justify-between">
                            <div>
                                <h1 class="text-black text-lg ">ยอดชำระเงินทั้งหมด </h1>
                            </div>
                            <div>
                                <h1 class="font-bold text-lg "><?php echo number_format($_SESSION['ses_total']) ?> บาท</h1>
                            </div>
                        </div>

                        <div class="my-3 p-3 w-full " style="background-color: #F1F2F6;">
                            <p class="text-gray-400  ">
                                1. ชำระเงินผ่านการโอนเงิน Internet banking มายังบัญชีข้างล่างนี้
                            </p>
                        </div>

                        <div class="flex justify-center ">
                            <?php
                            $get_bank = $db->qty("SELECT * FROM tb_bank");
                            while ($get = $get_bank->fetch_object()) {

                            ?>
                                <div class="my-2 p-3 w-full bg-white">
                                    <input type="radio" class="h-5 w-5  " name="bank_id" value="<?php echo $get->bank_id; ?>" required>

                                    <p class=" text-black ">
                                        <?php echo $get->bank_name; ?>
                                    </p>
                                    <p class="text-gray-400">ชื่อบัญชี: <?php echo $get->bank_username ?></p>
                                    <p class="text-gray-400">เลขที่บัญชี: <?php echo $get->bank_number; ?></p>
                                </div>

                            <?php } ?>
                        </div>
                        <div class="my-3 p-3 w-full " style="background-color: #F1F2F6;">
                            <p class="text-gray-400  ">
                                2. เก็บหลักฐานการโอนเงินและอัพโหลด
                                หลักฐานการโอนเงิน </p>
                            <p class="text-gray-400 my-2 ">
                                3. กรุณารอพนักงานยืนยันการชำระเงิน
                                ภายใน 2ชม. หากเกินเวลาที่กำหนดให้ ติดต่อพนักงาน </p>
                        </div>

                        <div class="mx-3">
                            <h1 id="show_file" class="text-center mx-3 my-2 text-md mt-2 font-bold">ยังไม่ได้อัปรูปภาพ</h1>
                            <label class="font-bold cursor-pointer w-full py-2 px-3 text-white bg-red-500 text-md text-center rounded-md outline-none border-none hover:bg-red-600">
                                <input type="file" class="hidden" name="bank_img" id="pro_img" accept="image/*" required> มีหลักฐานการชำระเงิน อัพโหลดเลย</label>
                        </div>

                        <div class="mx-3 mb-4">
                            <button type="submit" class="font-bold w-full  text-md text-center py-2 px-3 text-white bg-blue-500 hover:bg-blue-500 rounded-md">บันทีก</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


<script>
    $(document).ready(function() {
        $("#pro_img").change(() => {
            var files = $("#pro_img")[0].files[0].name;
            $("#show_file").text(files);
        });
    });

    $(".plus").click(function() {
        updateValue(this, 1);
    });
    $(".minus").click(function() {
        updateValue(this, -1);
    });

    function updateValue(obj, delta) {
        let item = $(obj).parent().find("input");
        let newValue = parseInt(item.val(), 10) + delta;
        item.val(Math.max(newValue, 0));
    }
</script>