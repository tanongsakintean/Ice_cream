<?php
if (isset($_SESSION['ses_status'])) {
    if ($_SESSION['ses_status'] != 2 && $_SESSION['ses_status'] != 3) {
        echo "<script>window.location.reload()</script>";
    }
}

include("./class/MangeOrderClass.php");
$order = new MangeOrderClass();
$get_pro = $order->qty("SELECT * FROM tb_product");

?>
<style>
    .pro:hover {
        box-shadow: 0px 2px 12px 2px rgba(252, 0, 0, 1);
    }
</style>
<div class="container-fluid p-5 bg-white ">
    <div class="flex  justify-start">
        <div class="row w-4/5 mx-1">

            <?php

            while ($get = $get_pro->fetch_object()) {
            ?>
                <div onclick="add_order(`<?php echo $get->pro_name; ?>`,<?php echo $get->pro_price; ?>,<?php echo $get->pro_id; ?>)" style="height: min-content;" class="border-2 bg-white pro cursor-pointer w-56 flex flex-col justify-end border-gray-200 shadow-md rounded-md m-1 ">
                    <div class="flex justify-center">
                        <img class="h-26" src="images/products/<?php echo $get->pro_img; ?>" alt="">
                    </div>
                    <div class="bg-black relative  -mt-10 opacity-75 rounded-md p-2">
                        <h1 class="text-lg text-white text-center "><?php echo $get->pro_name; ?></h1>
                    </div>
                </div>
            <?php  } ?>
        </div>

        <div style="height: 43rem;" class="mx-1 px2 py-3  bg-white   w-96 border-2  border-gray-300  shadow-md ">
            <div class="flex justify-around items-center">
                <h1 class="text-lg font-bold ">สินค้า</h1>
                <h1 class="text-lg font-bold ">จำนวน</h1>
                <h1 class="text-lg font-bold ">ราคา</h1>
            </div>
            <div style="height: 32rem;" id="order" class="overflow-auto  ">
            </div>

            <div class="flex w-full px-3 py-2  justify-between">
                <div>
                    <h1 class="text-lg font-bold text-black">รวม</h1>
                </div>
                <div>
                    <h1 class=" total text-lg font-bold text-black">0 บาท</h1>
                </div>
            </div>
            <div class="flex justify-center w-full  p-2">
                <button onclick="" data-toggle="modal" data-target="#add_order" class=" text-white w-full text-lg py-2 px-2 bg-purple-500 hover:bg-purple-600 outline-none rounded-md text-center">ชำระเงิน</button>
            </div>
        </div>
    </div>



    <!-- Modal add_order -->
    <div class="modal fade bd-example-modal-lg" id="add_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header p-4">
                    <h5 class="text-lg " id="exampleModalLongTitle">รับเงิน</h5>
                    <i data-dismiss="modal" aria-label="Close" class="cursor-pointer text-red-500 text-xl hover:text-red-600 fas fa-window-close"></i>

                </div>
                <form action="action/order_db.php?ac=add_order" method="POST" onSubmit="return ajax_order(this)">
                    <div class="modal-body">

                        <div class="flex my-2 justify-between">
                            <div>
                                <h1 class="text-black font-bold text-lg">ราคารวม</h1>
                            </div>
                            <div>
                                <h1 class="total text-lg font-bold text-black">0 บาท</h1>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="my-2">
                                <h1 class="text-lg font-bold">จำนวนเงิน</h1>
                            </div>
                            <div class="my-2">
                                <input type="number" id="money" class="w-full px-3 py-2 text-lg outline-none border-gray-300 border-2 rounded-md" placeholder="กรอกจำนวนเงินรับมา" required>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer py-3">
                        <button type="submit" class="text-lg py-2 px-3 text-white bg-purple-500 hover:bg-purple-600 rounded-md">คิดเงิน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    order = [];
    i = 1;
    total = 0;
    var add_order = (pro_name, pro_price, pro_id) => {
        check = order.findIndex((order => order.pro_id == pro_id));
        if (check == -1) {
            order.push({
                "pro_id": `${pro_id}`,
                "pro_price": pro_price,
                "amount": i,
            });
            total += pro_price;
            $("#order").append(`<div class=" order flex justify-around my-2 ">
                    <h1 class="text-lg font-bold">${pro_name}</h1>
                    <h1 class="text-lg amount font-bold">${i}</h1>
                    <h1 class="text-lg  price font-bold">${pro_price} </h1>
                </div>`)
        } else {
            total += pro_price;
            order[check].amount += 1;
            order[check].pro_price += pro_price;
            $(`.order:nth-child(${check+1}) > .amount `).text(order[check].amount);
            $(`.order:nth-child(${check+1}) > .price `).text(new Intl.NumberFormat('en-IN', {
                maximumSignificantDigits: 3
            }).format(order[check].pro_price));
        }
        $(".total").text((total).toFixed(1).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " บาท");
    }

    var ajax_order = (formEl) => {
        if (total > $("#money").val()) {
            swal.fire({
                title: 'จำนวนเงินไม่พอ',
                html: `<h1 class="text-lg text-center font-bold">โปรดตรวจสอบเงินที่รับมาอีกครั้ง! </h1>`,
                icon: 'error',
                showCancelButton: false,
                showConfirmButton: false,
                timer: 1500
            });
        } else {

            sum_order = [order, total, $("#money").val()];

            $.ajax({
                type: "POST",
                url: $(formEl).attr("action"),
                data: {
                    order: JSON.stringify(sum_order),
                },
                success: function(data) {
                    if (JSON.parse(data)[0] == 1) {
                        swal.fire({
                            title: 'เงินทอน',
                            html: `<h1 class="text-xl text-center font-bold">${($("#money").val() - total).toFixed(1).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " บาท"} บาท</h1>`,
                            icon: 'success',
                            showCancelButton: false,
                            showConfirmButton: false,
                            timer: 1500,
                        }).then(() => {
                            window.open(`export_pdf/print_slip_pdf.php?id=${JSON.parse(data)[1]}`, "_blank");
                            window.location.replace("index.php?p=add_order");
                        })
                    }
                }
            })

        }
        return false;
    }
</script>