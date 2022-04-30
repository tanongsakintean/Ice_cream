<?php
$user = $db->qty("SELECT * FROM tb_member WHERE mem_id = '" . $_SESSION['ses_mem_id'] . "'")->fetch_object();

?>
<div>
    <div class="py-5 flex justify-center"> <i class="fas fa-user-circle  text-blue-500 hover:text-blue-600" style="font-size: 11rem;"></i></div>
    <div>

        <div class="flex justify-center my-2 items-center">
            <h1 class="font-bold" style="font-size: 21px;">ชื่อ :<span class="font-thin">
                    นาย <?php echo $user->mem_firstname ?>
                </span>
            </h1>
        </div>


        <div class="flex justify-center my-2 items-center">
            <h1 class="font-bold" style="font-size: 21px;">นามสกุล :<span class="font-thin">
                    <?php echo $user->mem_lastname ?>
                </span>
            </h1>
        </div>

        <div class="flex justify-center my-2 items-center">
            <h1 class="font-bold" style="font-size: 21px;">เพศ :<span class="font-thin">
                    ชาย
                </span>
            </h1>
        </div>

        <div class="flex justify-center my-2 items-center">
            <h1 class="font-bold" style="font-size: 21px;">เบอร์โทร :<span class="font-thin">
                    <?php echo $user->mem_phone ?>
                </span>
            </h1>
        </div>

        <div class="flex justify-center my-2 items-center">
            <h1 class="font-bold" style="font-size: 21px;">อีเมล :<span class="font-thin">
                    <?php echo $user->mem_username ?>
                </span>
            </h1>
        </div>


        <div class="flex justify-center my-2 items-center">
            <h1 class="font-bold" style="font-size: 21px;">คะแนน :<span class="font-thin">
                    <?php echo $user->mem_point ?>

                </span>
            </h1>
        </div>

        <div class="flex justify-center my-2 items-center">
            <h1 class="font-bold" style="font-size: 21px;">เข้าสู่ระบบล่าสุด :<span class="font-thin">
                    <?php echo date('d/m/', strtotime($user->last_login)) . substr($user->last_login, 0, 4) + 543 . " " . date('H:s', strtotime($user->last_login))  ?>
                </span>
            </h1>
        </div>

    </div>
</div>