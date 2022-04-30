<style>
    .show {
        display: block;
    }
</style>
<div class="px-4 sticky top-0 z-10 py-2 flex justify-between outline  outline-2 outline-red-500" style="background-image: url('https://www.swensens1112.com/assets/images/bg-white.jpg');">
    <div>
        <i id="fa-bar" class=" cursor-pointer fas fa-bars text-3xl text-red-500 "></i>
    </div>
    <div class="flex justify-center items-center">
        <a href="index.php" class="hover:no-underline hover:text-black text-lg text-black font-bold">
            ICE-CREAM
        </a>
    </div>
    <div class="flex justify-center">
        <a href="pages/login.php" class="hidden  cursor-pointer"><i class="fas fa-sign-in-alt  text-3xl text-red-500 mx-2"></i></a>
        <a href="index.php?p=order">
            <i class="fas  cursor-pointer fa-shopping-bag  text-3xl text-red-500 mx-1"></i>
            <?php if (isset($_SESSION['ses_cart'])) { ?>
                <span id="cart" style="top: 23px;right:15px;width:27px;padding:2px" class=" bg-gray-500  absolute rounded-full  text-center text-white"><?php echo count($_SESSION['ses_cart']); ?></span>
            <?php } ?>
        </a>
    </div>
</div>