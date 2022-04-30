<?php
include("./class/MangeOrderClass.php");
$order = new MangeOrderClass();
if (isset($_SESSION['ses_status'])) {
    if ($_SESSION['ses_status'] != 2 && $_SESSION['ses_status'] != 3) {
        echo "<script>window.location.reload()</script>";
    }
}
$get_order = $order->qty("SELECT * FROM tb_order WHERE pay_status = 0")->fetch_all();

?>
<div class="container-fluid  p-5 bg-white">
    <div>
        <div class="py-3 my-3">
            <h1 class="text-xl font-bold text-black ">รายการสั่งซื้อ</h1>
        </div>

        <div>
            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อผู้สั่งซื้อ</th>
                        <th>จำนวน</th>
                        <th>ราคารวมทั้งหมด</th>
                        <th>เบอร์โทร</th>
                        <th>การชำระเงิน</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($get_order); $i++) {
                        $user = $order->qty("SELECT * FROM tb_member WHERE mem_id = '" . $get_order[$i][1] . "'")->fetch_object();
                        $sum_amount = $order->qty("SELECT SUM(item_qty) FROM tb_order_item WHERE order_id = '" . $get_order[$i][0] . "'")->fetch_array();
                    ?>
                        <tr>
                            <td><?php echo $i + 1; ?></td>
                            <?php if ($user->mem_title == 1) { ?>
                                <td>นาย <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                            <?php } else if ($user->mem_title == 2) { ?>
                                <td>นาง <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                            <?php  } else if ($user->mem_title == 3) { ?>
                                <td>นางสาว <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                            <?php } ?>
                            <td><?php echo $sum_amount[0]; ?></td>
                            <td><?php echo number_format($get_order[$i][4]); ?> บาท</td>
                            <td><?php echo  substr($user->mem_phone, 0, 3) . "-" . substr($user->mem_phone, 3, 3) . "-" . substr($user->mem_phone, 6, 4); ?></td>
                            <td class="px-2 py-1 ">
                                <div class="px-1 mt-2 py-1  h-ull rounded-md bg-yellow-400">
                                    <?php if ($get_order[$i][6] == 0) { ?>
                                        <h1 class="text-center text-white font-bold text-lg ">รอยืนยันการชำระเงิน</h1>
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
                                <div class="flex  items-center">
                                    <button data-toggle="modal" data-target="#get_order<?php echo $get_order[$i][0] ?>" class="text-lg font-bold py-1 px-2 text-center bg-green-500 hover:bg-green-600 w-full rounded-md text-white">จัดการ</button>
                                </div>
                            </td>
                        </tr>




                    <?php }  ?>
                </tbody>

            </table>
        </div>
    </div>

    <!-- Modal get_order -->
    <?php
    for ($i = 0; $i < count($get_order); $i++) {
        $user = $order->qty("SELECT * FROM tb_member WHERE mem_id = '" . $get_order[$i][1] . "'")->fetch_object();
    ?>
        <div class="modal fade bd-example-modal-lg" id="get_order<?php echo $get_order[$i][0] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header p-4">
                        <h5 class="text-xl " id="exampleModalLongTitle">รายการสั่งซื้อ</h5>
                        <i data-dismiss="modal" aria-label="Close" class="cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>

                    </div>
                    <form action="" method="post">
                        <div class="modal-body">

                            <div class="flex">
                                <table class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $order_item = $order->qty("SELECT * FROM tb_order_item WHERE order_id = '" . $get_order[$i][0] . "'")->fetch_all();

                                        for ($j = 0; $j < count($order_item); $j++) {
                                            $item_pro = $order->qty("SELECT pro_name,pro_price FROM tb_product WHERE  pro_id = '" . $order_item[$j][2] . "'")->fetch_object();
                                        ?>
                                            <tr>
                                                <td><?php echo $j + 1; ?></td>
                                                <td><?php echo $item_pro->pro_name; ?></td>
                                                <td><?php echo $order_item[$j][3] ?></td>
                                                <td><?php echo number_format($item_pro->pro_price * $order_item[$j][3]); ?> บาท</td>
                                            </tr>
                                        <?php } ?>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>รวม</td>
                                            <td><?php echo number_format($get_order[$i][4]) ?> บาท</td>
                                        </tr>


                                    </tbody>

                                </table>
                                <table class="table table-striped table-bordered dt-responsive nowrap" style="width: 28%;">
                                    <thead>
                                        <th>ตรวจสอบการโอนเงิน</th>
                                    </thead>
                                    <tbody>
                                        <td>
                                            <div class="my-2">
                                                <a target="_blank" href="images/slips/<?php echo $get_order[$i][8];  ?>">
                                                    <img class="h-14 w-36 bg-cover bg-center    cursor-pointer" src="images/slips/<?php echo $get_order[$i][8];  ?>" alt="" srcset="">
                                                </a>
                                            </div>
                                            <div class="my-2">
                                                <button onclick="return confirm_pay(<?php echo $get_order[$i][0]; ?>)" class="text-md  py-2 px-3 bg-green-500 hover:bg-green-600 text-white  rounded-md font-bold"><i class="fas fa-check-circle text-lg text-white"></i> ชำระเงินแล้ว</button>
                                            </div>
                                        </td>
                                    </tbody>
                                </table>

                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "searching": false,
        });

    });

    function confirm_pay(id) {
        $.ajax({
            type: "POST",
            url: `action/order_db.php?ac=confirm_pay`,
            data: {
                order_id: id,
            },
            dataType: "html",
            success: (data) => {
                if (data == 1) {
                    swal.fire({
                        title: 'ยืนยันสำเร็จ',
                        html: `<h1 class='text-lg text-center font-bold'>ยืนยันการชำระเงินสำเร็จ! </h1>`,
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.open('export_pdf/print_slip_pdf.php?id=' + id);
                        window.location.replace("index.php?p=get_order");
                    })
                }
            }
        });
        return false;
    }
</script>