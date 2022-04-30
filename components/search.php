<div class="mt-4">
    <div class="flex justify-center items-center">
        <h1 class=" text-red-500  " style="font-size: 23px ;">ค้นหา</h1>
    </div>

    <form action="action/product_db.php?ac=search" id="formEl" class=" mx-4 mt-3 flex justify-center items-center" method="POST">
        <i class="fas fa-search text-lg text-gray-400 absolute left-9"></i>
        <input type="text" id="search" name="keyword" class="w-full border-2 border-gray-300 hover:border-blue-500  pl-10 pr-2 py-2  text-md rounded-md outline-none shadow-lg" placeholder="ค้นหาจาก ชื่อสินค้า, ประเภทสินค้า">
    </form>


    <!---- products----->

    <div class="py-4">
        <div class="flex justify-center  my-3 ">
            <h1 class="text-red-500  " style="font-size: 30px;" id="title"> </h1>
        </div>
        <div class="flex justify-center flex-wrap  pl-3 m-0 w-full" id="boxSearch">
        </div>
    </div>

    <?php if (isset($_SESSION['ses_status'])) {

    ?>
        <script type="text/javascript" src="js/search.js"></script>

    <?php } else { ?>

        <script type="text/javascript" src="js/Nsearch.js"> </script>
    <?php } ?>