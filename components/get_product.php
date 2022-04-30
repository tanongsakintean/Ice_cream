<?php
$order_id = $db->qty("SELECT order_id FROM tb_order WHERE mem_id = '" . $_SESSION['ses_mem_id'] . "' AND DAY(order_date) = DAY(NOW())")->fetch_all();
if (isset($order_id)) {
    $order = [];
    for ($i = 0; $i < count($order_id); $i++) {
        array_push($order, $order_id[$i][0]);
    }
    $get_order = $db->qty("SELECT * FROM tb_order_item WHERE pay_status = 0 AND order_id IN (" . implode(",", $order) . ")")->fetch_all();
}

?>
<div class="pt-4">
    <div class="flex justify-center  items-center">
        <h1 class=" text-red-500 mx-1" style="font-size: 23px;">ได้รับสินค้า</h1>
        <?php if (isset($order_id)) { ?>
            <p class="text-gray-500 mx-1 mt-1" style="font-size: 15px;"><?php echo count($get_order); ?> รายการ</p>
        <?php } else { ?>
            <p class="text-gray-500 mx-1 mt-1" style="font-size: 15px;">0 รายการ</p>
        <?php } ?>
    </div>

    <div class=" flex justify-center flex-wrap m-0">
        <?php
        if (isset($order_id)) {

            for ($i = 0; $i < count($get_order); $i++) {
                $get = $db->qty("SELECT * FROM tb_product WHERE pro_id = '" . $get_order[$i][2] . "'")->fetch_object();

        ?>
                <div class="my-3 mx-2  py-3 px-2 " style="width: 27rem;">

                    <div class=" rounded-lg justify-center bg-white  shadow-md py-3 ">
                        <div class="flex pl-3">
                            <div class="mr-3 ">
                                <img style="height: 175px;" src="images/products/<?php echo $get->pro_img; ?>" alt="">
                            </div>
                            <div class="mx-1">
                                <div>
                                    <h1 style="font-size: 20px;" class=" text-black"> <?php echo $get->pro_name; ?> </h1>
                                    <p style="font-size:16px;margin-top:1px;" class="text-gray-400 text-md">1 <?php echo $get->pro_unit_id; ?> | <?php echo $get->pro_price; ?> บาท</p>
                                    <div class="flex my-2 justify-start  items-end">
                                        <h1 style="font-size: 20px;"><?php echo number_format($get_order[$i][3] * $get->pro_price); ?></h1><span class="mx-1"> <i style="font-size:16px;">บาท</i></span>
                                    </div>
                                    <div class="mt-12 flex items-start flex-col">
                                        <?php
                                        $pay_status = $db->qty("SELECT pay_status FROM tb_order WHERE order_id = '" . $get_order[$i][1] . "'")->fetch_object();

                                        if ($pay_status->pay_status == 0) { ?>
                                            <h1 class="text-md text-white text-center   py-2 px-2 bg-yellow-400 rounded-md outline-none">รอยืนยัน</h1>
                                        <?php  } else { ?>
                                            <button onclick="return get_pro(<?php echo $get_order[$i][0]; ?>)" class="text-md  hover:text-white text-white text-center   py-2 px-2 bg-blue-500 hover:bg-blue-600 rounded-md outline-none">ได้สินค้าแล้ว</button>
                                        <?php } ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>


                </div>
        <?php }
        } ?>




    </div>

</div>

<script>
    function get_pro(id) {
        $.ajax({
            type: "POST",
            url: "action/order_db.php?ac=get_pro",
            data: {
                item_id: id
            },
            dataType: "html",
            success: (data) => {
                if (data == 1) {
                    window.location.replace("index.php?p=get_product");
                }
            }
        });
        return false;
    }
</script>