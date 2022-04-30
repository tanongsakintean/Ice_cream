<?php


$pro = $db->qty("SELECT * FROM tb_product WHERE pro_category_id = '" . $_REQUEST['id'] . "'");
$cate = $db->qty("SELECT * FROM tb_product WHERE pro_category_id = '" . $_REQUEST['id'] . "'");
?>
<!---- products----->

<div class="py-4">

    <div class="flex justify-center  mt-3 ">
        <?php
        if ($cate->num_rows == 0) {
        ?>
            <h1 class="text-red-500  " style="font-size: 30px;"> ไม่พบสินค้าในหมวดหมู่นี้ </h1>
        <?php } else { ?>
            <h1 class="text-red-500  " style="font-size: 30px;"><?php echo $cate->fetch_object()->pro_category_id; ?> </h1>
    </div>
    <div class="pl-3 flex justify-center flex-wrap m-0">

        <?php
            while ($get = $pro->fetch_object()) {

        ?>
            <div class="item w-96">
                <div class=" flex justify-center p-8 w-full">
                    <div class="bg-white rounded-lg shadow-md">
                        <div class="px-16 pt-4 flex justify-center items-start">
                            <img src="images/products/<?php echo $get->pro_img; ?>" alt="">
                        </div>
                        <div>
                            <h1 class="text-md text-red-600 py-2 text-center"> <?php echo $get->pro_name; ?> </h1>
                            <div class="py-4">
                                <?php if ($get->pro_description1 == "") { ?>
                                    <p class="text-center text-gray-500 mt-4"></p>
                                <?php } else { ?>
                                    <p class="text-center text-gray-500 "><?php echo $get->pro_description1; ?></p>
                                <?php } ?>
                                <?php if ($get->pro_description2 == "") { ?>
                                    <p class="text-center text-gray-500 mt-4"></p>
                                <?php } else { ?>
                                    <p class="text-center text-gray-500 "><?php echo $get->pro_description2; ?></p>
                                <?php } ?>
                            </div>
                            <p class="text-center text-gray-500">1 <?php echo $get->pro_unit_id; ?> | <?php echo $get->pro_price; ?> บาท</p>
                            <div class="flex justify-center px-3 py-4">
                                <?php
                                if (isset($_SESSION['ses_status'])) {
                                ?>
                                    <button onclick="add_order(<?php echo $get->pro_id; ?>)" class="text-md py-2 text-white rounded-md w-full px-3 bg-red-500 hover:bg-red-600">สั่งซื้อ</button>
                                <?php } else { ?>
                                    <a href="pages/login.php" class=" mx-2 text-lg text-red-500    hover:no-underline">
                                        เข้าสู่ระบบ
                                    </a> | <a href="pages/register.php" class="mx-2 text-lg text-red-500   hover:no-underline">
                                        สมัครสมาชิก
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    <?php } ?>

    </div>
</div>
<script>
    function add_order(pro_id) {
        $.ajax({
            type: "POST",
            url: "action/order_db.php?ac=i_order",
            data: {
                order: pro_id
            },
            dataType: "html",
            success: function(data) {
                $("#cart").text(parseInt(data));
            },
        });
    }
</script>