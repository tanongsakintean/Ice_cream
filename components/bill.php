<?php

include("./class/MangeOrderClass.php");
$order = new MangeOrderClass();
if (isset($_SESSION['ses_status'])) {
    if ($_SESSION['ses_status'] != 2 && $_SESSION['ses_status'] != 3) {
        echo "<script>window.location.reload()</script>";
    }
}
$get_order = $order->qty("SELECT * FROM tb_order WHERE pay_status = 1 ORDER BY order_date DESC")->fetch_all();


if (isset($_REQUEST['ac'])) {
    if ($_REQUEST['ac'] == "date") {
        $sort_order = $order->qty("SELECT * FROM tb_order WHERE pay_status = 1 AND order_date BETWEEN '" . $_REQUEST['date_start'] . "' AND '" . $_REQUEST['date_end'] . "' ORDER BY order_date DESC")->fetch_all();
    }
}

?>
<div class="container-fluid p-5 bg-white">
    <div>
        <div class="py-3 my-3">
            <h1 class="text-xl font-bold text-black ">สรุปยอดขาย</h1>
        </div>
        <div class="flex absolute top-48 ml-52 z-10 justify-between my-2">
            <form action="?p=bill&ac=date" method="POST">
                <div class="flex">
                    <div class="flex mx-2">
                        <h1 class="p-2 text-lg font-bold ">FROM</h1>
                        <input type="date" class="rounded-md border-gray-200 outline-none border-2 p-2" name="date_start" id="" required>
                    </div>
                    <div class="flex mx-2">
                        <h1 class="p-2 text-lg font-bold ">TO</h1>
                        <input type="date" class=" rounded-md border-gray-200 outline-none border-2 p-2" name="date_end" id="" required>
                    </div>

                    <div class="mx-2">
                        <button type="submit" class="px-3 py-2 bg-purple-500 hover:bg-purple-600 text-lg text-white rounded-md font-bold ">ค้นหา</button>
                    </div>
                    <div class="flex justify-end" style="margin-left: 26rem;">
                        <?php if (isset($_REQUEST['ac']) == "date") { ?>
                            <a href="export_pdf/print_pdf.php?start=<?php echo  $_REQUEST['date_start']; ?>&end=<?php echo $_REQUEST['date_end'] ?>" target="_bank" class="text-white hover:no-underline rounded-md text-md font-bold py-2 px-3 bg-gray-500 hover:bg-gray-600"><i class="fas fa-print text-lg text-white"></i> พิมพ์ใบเสร็จทั้งหมด</a>
                        <?php } else { ?>
                            <a href="export_pdf/print_pdf.php" target="_bank" class="text-white hover:no-underline rounded-md text-md font-bold py-2 px-3 bg-gray-500 hover:bg-gray-600"><i class="fas fa-print text-lg text-white"></i> พิมพ์ใบเสร็จทั้งหมด</a>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
        <div>
            <table id="datatable" class=" table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อผู้สั่งซื้อ</th>
                        <th>จำนวน</th>
                        <th>ธนาคาร</th>
                        <th>วันที่ชำระ</th>
                        <th>ราคารวมทั้งหมด</th>
                        <th>การชำระเงิน</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!isset($sort_order)) {

                        for ($i = 0; $i < count($get_order); $i++) {
                            $user = $order->qty("SELECT * FROM tb_member WHERE mem_id = '" . $get_order[$i][1] . "' ")->fetch_object();
                            $sum_amount = $order->qty("SELECT SUM(item_qty) FROM tb_order_item WHERE order_id = '" . $get_order[$i][0] . "'")->fetch_array();
                            $bank = $order->qty("SELECT * FROM tb_bank WHERE bank_id = '" . $get_order[$i][7] . "'")->fetch_object();
                    ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <?php if ($get_order[$i][1] > 0) { ?>
                                    <?php if ($user->mem_title == 1) { ?>
                                        <td>นาย <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                                    <?php } else if ($user->mem_title == 2) { ?>
                                        <td>นาง <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                                    <?php  } else if ($user->mem_title == 3) { ?>
                                        <td>นางสาว <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                                    <?php }
                                } else { ?>
                                    <td>ลูกค้าทั่วไป</td>
                                <?php  } ?>
                                <td><?php echo $sum_amount[0];
                                    ?></td>
                                <?php if ($get_order[$i][1] > 0) {
                                ?>
                                    <td><?php echo $bank->bank_name; ?></td>
                                <?php } else { ?>
                                    <td>เงินสด</td>
                                <?php } ?>
                                <td><?php echo date('d/m/', strtotime($get_order[$i][2])) . substr($get_order[$i][2], 0, 4) + 543; ?></td>
                                <td><?php echo number_format($get_order[$i][4]); ?> บาท</td>
                                <td class="px-2 py-1 ">
                                    <div class="px-2 mt-2 py-1  h-full rounded-md bg-green-500">
                                        <h1 class="text-center text-white font-bold text-lg ">ชำระเงินแล้ว</h1>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex justify-center  items-center">
                                        <a href="export_pdf/print_slip_pdf.php?id=<?php echo $get_order[$i][0]; ?>" target="_bank" class="text-white hover:no-underline rounded-md text-md font-bold py-2 px-3 bg-gray-500 hover:bg-gray-600"><i class="fas fa-print text-lg text-white"></i> พิมพ์ใบเสร็จ</a>
                                    </div>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        for ($i = 0; $i < count($sort_order); $i++) {
                            $user = $order->qty("SELECT * FROM tb_member WHERE mem_id = '" . $sort_order[$i][1] . "'")->fetch_object();
                            $sum_amount = $order->qty("SELECT SUM(item_qty) FROM tb_order_item WHERE order_id = '" . $sort_order[$i][0] . "'")->fetch_array();
                            $bank = $order->qty("SELECT * FROM tb_bank WHERE bank_id = '" . $sort_order[$i][7] . "'")->fetch_object();
                        ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <?php if ($get_order[$i][1] > 0) { ?>
                                    <?php if ($user->mem_title == 1) { ?>
                                        <td>นาย <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                                    <?php } else if ($user->mem_title == 2) { ?>
                                        <td>นาง <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                                    <?php  } else if ($user->mem_title == 3) { ?>
                                        <td>นางสาว <?php echo $user->mem_firstname; ?>​ <?php echo $user->mem_lastname; ?></td>
                                    <?php }
                                } else { ?>
                                    <td>ลูกค้าทั่วไป</td>
                                <?php } ?>
                                <td><?php echo $sum_amount[0];
                                    ?></td>
                                <?php if ($get_order[$i][1] > 0) {
                                ?>
                                    <td><?php echo $bank->bank_name; ?></td>
                                <?php } else { ?>
                                    <td>เงินสด</td>
                                <?php } ?>
                                <td><?php echo date('d/m/', strtotime($get_order[$i][2])) . substr($get_order[$i][2], 0, 4) + 543; ?></td>
                                <td><?php echo number_format($sort_order[$i][4]); ?> บาท</td>
                                <td class="px-2 py-1 ">
                                    <div class="px-2 mt-2 py-1  h-full rounded-md bg-green-500">
                                        <h1 class="text-center text-white font-bold text-lg ">ชำระเงินแล้ว</h1>
                                    </div>
                                </td>
                                <td>
                                    <div class="flex justify-center  items-center">
                                        <a href="export_pdf/print_slip_pdf.php?id=<?php echo $get_order[$i][0]; ?>" target="_bank" class="text-white hover:no-underline rounded-md text-md font-bold py-2 px-3 bg-gray-500 hover:bg-gray-600"><i class="fas fa-print text-lg text-white"></i> พิมพ์ใบเสร็จ</a>
                                    </div>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "searching": false,
        });

    });
</script>