<?php
$cate = $db->qty("SELECT * FROM tb_category");
?>
<div id="display" class="fixed hidden h-screen bg-red-500 top-0 z-30 w-80" style="box-shadow: 2px 0px 5px 0px rgba(0,0,0,0.44)">
    <div class="px-4 py-2 flex  justify-between    " style="height: 52px;background-image: url('https://www.swensens1112.com/assets/images/bg-white.jpg');">
        <div></div>
        <div class="flex justify-center items-center">
            <a href="index.php" class="text-lg text-black font-bold hover:text-black hover:no-underline">ICE-CREAM</a>
        </div>
        <div class="flex-end">
            <i id="close" class="cursor-pointer fas float-right fa-times text-xl text-red "></i>
        </div>
    </div>
    <div>
        <div class="flex justify-start items-center py-2 px-4">
            <a href="index.php?p=search" class="text-lg text-white   hover:no-underline">
                <i class="fas fa-search text-lg text-white px-2"></i> ค้นหา
            </a>
        </div>
        <?php

        while ($get = $cate->fetch_object()) {

        ?>
            <div class="flex justify-start items-center py-2 px-4">
                <a href="index.php?p=cate_product&id=<?php echo $get->cate_name; ?>" class="text-lg text-white   hover:no-underline">
                    <i class="far fa-dot-circle text-lg text-white px-2"></i> <?php echo $get->cate_name; ?>
                </a>
            </div>
        <?php } ?>


        <?php
        if (isset($_SESSION['ses_status'])) {
        ?>
            <div class="flex justify-start items-center py-2 px-4">
                <a href="index.php?p=get_product" class="text-lg text-white   hover:no-underline">
                    <i class="fas fa-ice-cream text-lg text-white px-2"></i> ได้รับสินค้า
                </a>
            </div>

            <div class="flex justify-start items-center py-2 px-4">
                <a href="index.php?p=profile" class="text-lg text-white   hover:no-underline">
                    <i class="fas fa-user-circle  text-lg text-white px-2"></i> โปรไฟล์
                </a>
            </div>

            <div class="flex justify-start items-center py-2 px-4">
                <a href="index.php?s=log" class="text-lg text-white   hover:no-underline">
                    <i class="fas fa-arrow-circle-right text-lg text-white px-2"></i> ออกจากระบบ
                </a>
            </div>
        <?php } else { ?>

            <div class="flex justify-start items-center py-2 px-4">
                <a href="pages/register.php" class="text-lg text-white   hover:no-underline">
                    <i class="fas fa-user-circle  text-lg text-white px-2"></i> สมัครสมาชิก
                </a>
            </div>

            <div class="flex justify-start items-center py-2 px-4">
                <a href="pages/login.php" class="text-lg text-white   hover:no-underline">
                    <i class="fas fa-arrow-circle-right text-lg text-white px-2"></i> เข้าสู่ระบบ
                </a>
            </div>

        <?php } ?>
    </div>
</div>

<script>
    $('#fa-bar').on('click', function() {
        $('#display').toggleClass('show');
    })
    $('#close').on('click', function() {
        $("#display").removeClass("show")
    })
</script>