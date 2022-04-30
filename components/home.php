<?php
$banner = $db->qty("SELECT * FROM tb_promotion");
$pro_sale = $db->qty("SELECT * FROM tb_product ORDER BY pro_pop DESC");
$pro_pop = $db->qty("SELECT * FROM tb_product   ");
$pro_new = $db->qty("SELECT * FROM tb_product ORDER BY pro_id DESC");
?>
<style>
    .owl-theme .owl-dots .owl-dot span {
        height: 21px !important;
        width: 21px !important;
        border: 2px solid #E74C3C;
        background-color: transparent;
    }

    .owl-theme .owl-dots .owl-dot.active span,
    .owl-theme .owl-dots .owl-dot:hover span {
        background-color: #E74C3C;
    }
</style>
<div>
    <div class="w-full " style="margin-top: 2px;">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators p-1">
                <?php

                for ($i = 0; $i < $banner->num_rows; $i++) {
                    if ($i == 0) {
                ?>
                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" style="height: 9px;border:3px solid #ffffff;width:9px;" class="rounded-full active"></li>

                    <?php } else {  ?>
                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" style="height: 9px;border:3px solid #ffffff;width:9px;" class="rounded-full"></li>

                <?php }
                } ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $i = 1;
                while ($get = $banner->fetch_object()) {
                    if ($i == 1) {
                ?>
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/promotions/<?php echo $get->pm_img; ?>" alt="First slide">
                        </div>

                    <?php $i = 0;
                    } else { ?>
                        <div class="carousel-item ">
                            <img class="d-block w-100" src="images/promotions/<?php echo $get->pm_img; ?>" alt="First slide">
                        </div>
                <?php }
                } ?>


            </div>

        </div>
        <!-- Products -->
        <div class="py-4">

            <div class="flex justify-center  mt-3 ">
                <h1 class="text-red-500  " style="font-size: 30px;">สินค้าขายดี</h1>
            </div>
            <div class="owl-carousel owl-theme">
                <?php

                while ($get = $pro_pop->fetch_object()) {
                ?>
                    <div class="item">
                        <div class=" flex justify-center p-8 w-full">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="px-16 pt-4 flex justify-center items-start">
                                    <img src="images/products/<?php echo $get->pro_img; ?>" alt="">
                                </div>
                                <div>
                                    <h1 class="text-md text-red-600 py-2 text-center"><?php echo $get->pro_name; ?> </h1>
                                    <div class="py-4">
                                        <?php if ($get->pro_description1 == "") {
                                        ?>
                                            <p class="text-center text-gray-500 mt-4"><?php echo $get->pro_description1; ?></p>
                                        <?php } else { ?>
                                            <p class="text-center text-gray-500 "><?php echo $get->pro_description1; ?></p>
                                        <?php } ?>
                                        <?php if ($get->pro_description2 == "") {
                                        ?>
                                            <p class="text-center text-gray-500 mt-4"><?php echo $get->pro_description2; ?></p>
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
                <?php
                } ?>




            </div>
        </div>


        <!-- Products -->
        <div class="py-4">

            <div class="flex justify-center  mt-3 ">
                <h1 class="text-red-500  " style="font-size: 30px;">สินค้ายอดนิยม</h1>
            </div>
            <div class="owl-carousel owl-theme">
                <?php

                while ($get = $pro_sale->fetch_object()) {
                ?>
                    <div class="item">
                        <div class=" flex justify-center p-8 w-full">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="px-16 pt-4 flex justify-center items-start">
                                    <img src="images/products/<?php echo $get->pro_img; ?>" alt="">
                                </div>
                                <div>
                                    <h1 class="text-md text-red-600 py-2 text-center"><?php echo $get->pro_name; ?> </h1>
                                    <div class="py-4">
                                        <?php if ($get->pro_description1 == "") {
                                        ?>
                                            <p class="text-center text-gray-500 mt-4"><?php echo $get->pro_description1; ?></p>
                                        <?php } else { ?>
                                            <p class="text-center text-gray-500 "><?php echo $get->pro_description1; ?></p>
                                        <?php } ?>
                                        <?php if ($get->pro_description2 == "") {
                                        ?>
                                            <p class="text-center text-gray-500 mt-4"><?php echo $get->pro_description2; ?></p>
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
                <?php
                } ?>

            </div>
        </div>

        <!-- Products -->
        <div class="py-4">

            <div class="flex justify-center  mt-3 ">
                <h1 class="text-red-500  " style="font-size: 30px;">สินค้ามาใหม่</h1>
            </div>
            <div class="owl-carousel owl-theme">
                <?php

                while ($get = $pro_new->fetch_object()) {
                ?>
                    <div class="item">
                        <div class=" flex justify-center p-8 w-full">
                            <div class="bg-white rounded-lg shadow-md">
                                <div class="px-16 pt-4 flex justify-center items-start">
                                    <img src="images/products/<?php echo $get->pro_img; ?>" alt="">
                                </div>
                                <div>
                                    <h1 class="text-md text-red-600 py-2 text-center"><?php echo $get->pro_name; ?> </h1>
                                    <div class="py-4">
                                        <?php if ($get->pro_description1 == "") {
                                        ?>
                                            <p class="text-center text-gray-500 mt-4"><?php echo $get->pro_description1; ?></p>
                                        <?php } else { ?>
                                            <p class="text-center text-gray-500 "><?php echo $get->pro_description1; ?></p>
                                        <?php } ?>
                                        <?php if ($get->pro_description2 == "") {
                                        ?>
                                            <p class="text-center text-gray-500 mt-4"><?php echo $get->pro_description2; ?></p>
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
                <?php
                } ?>




            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            dots: true,
            nav: false,
            responsive: {
                0: {
                    items: 1,
                    nav: false,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 5,
                    nav: true,
                    loop: true,
                },
            },
        });
    });

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