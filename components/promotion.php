<?php
if (isset($_SESSION['ses_status'])) {
    if ($_SESSION['ses_status'] != 2 && $_SESSION['ses_status'] != 3) {
        echo "<script>window.location.reload()</script>";
    }
}

include("class/MangeProductClass.php");
$mep = new MangeProductClass();
$pm = $mep->qty("SELECT * FROM tb_promotion");
$it = $mep->qty("SELECT * FROM tb_promotion");

?>
<div class="container-fluid  p-5 bg-white">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators p-2">
            <?php

            for ($i = 0; $i < $pm->num_rows; $i++) {
                if ($i == 0) {
            ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" style="height: 15px;border:3px solid #ffffff;width:15px;" class="rounded-full  shadow-md active"></li>
                <?php } else {  ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i ?>" style="height: 15px;border:3px solid #ffffff;width:15px;" class="rounded-full  shadow-md "></li>
            <?php }
            } ?>

        </ol>
        <div class="carousel-inner">
            <?php
            $i = 1;
            while ($get = $pm->fetch_object()) {
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
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <form action="action/product_db.php?ac=add_pm" method="POST" enctype="multipart/form-data">
        <div class="flex mt-5 justify-between">
            <div class="mx-3 flex ">
                <label class=" cursor-pointer  py-2 px-3 text-white bg-green-500 text-lg rounded-md outline-none border-none hover:bg-green-600"><input type="file" class="hidden" name="pm_img" id="input_val"><i class="fas fa-plus"></i> เพิ่มรูปภาพ</label>
                <h1 id="show_fie" class="text-center mx-3 text-md mt-2 font-bold"></h1>
            </div>
            <div class="mx-3 flex ">
                <button type="submit" class="  py-2 px-3 text-white bg-purple-500 text-lg rounded-md outline-none border-none hover:bg-purple-600"><i class="fas fa-save"></i> บันทึก</button>
            </div>

        </div>
    </form>
    <div class="p-5 row">
        <?php
        while ($get = $it->fetch_object()) {

        ?>
            <div class="flex m-4">
                <i onclick="del_img(<?php echo $get->pm_id; ?>)" class="fas fa-window-close text-xl cursor-pointer text-red-500 hover:text-red-600"></i>
                <img class="h-28 " src="images/promotions/<?php echo $get->pm_img; ?>" alt="" srcset="">
            </div>
        <?php } ?>



    </div>
</div>



<script type="text/javascript" src="js/promotion.js">
</script>