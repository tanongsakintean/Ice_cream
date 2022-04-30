<?php
session_start();
include("../class/MangeUserClass.php");
$meu = new MangeUserClass();


if (isset($_REQUEST['ac'])) {
    switch ($_REQUEST['ac']) {
        case 'reg':
            if ($meu->check_username($_REQUEST['mem_username'])->num_rows) {
                echo 0;
            } else {
                $meu->qty("INSERT INTO tb_member (`mem_username`,`mem_password`,`mem_firstname`,`mem_lastname`,`mem_gender`,`mem_title`,`mem_phone`,`mem_point`,`mem_status`,`last_login`) VALUES ('" . $_REQUEST['mem_username'] . "','" . $_REQUEST['mem_password'] . "','" . $_REQUEST['mem_firstname'] . "','" . $_REQUEST['mem_lastname'] . "','" . $_REQUEST['mem_gender'] . "','" . $_REQUEST['mem_title'] . "','" . $_REQUEST['mem_phone'] . "',0,1,now()) ");
                echo $meu->setSes_Status($meu->check_username($_REQUEST['mem_username'])->fetch_object()->mem_status);
            }
            break;
        case 'log':
            echo $meu->check_login($_REQUEST['mem_username'], $_REQUEST['mem_password']);
            break;
        case 'forgot':
            echo $meu->forgot_password($_REQUEST['mem_username'], $_REQUEST['mem_phone'], $_REQUEST['mem_password']);
            break;
        case 'new_cus':
            if ($meu->check_username($_REQUEST['mem_username'])->num_rows) {
                echo 0;
            } else {
                $meu->qty("INSERT INTO tb_member (`mem_username`,`mem_password`,`mem_firstname`,`mem_lastname`,`mem_gender`,`mem_title`,`mem_phone`,`mem_point`,`mem_status`,`last_login`) VALUES ('" . $_REQUEST['mem_username'] . "','" . $_REQUEST['mem_password'] . "','" . $_REQUEST['mem_firstname'] . "','" . $_REQUEST['mem_lastname'] . "','" . $_REQUEST['mem_gender'] . "','" . $_REQUEST['mem_title'] . "','" . $_REQUEST['mem_phone'] . "',0,1,now()) ");
                echo 1;
            }
            break;
        case 'del':
            echo $meu->del($_REQUEST['mem_id']);
            break;
        case 'edit';
            $meu->edit_user($_REQUEST['mem_id']);
            break;
        case 'edit_cus':
            $meu->qty("UPDATE `tb_member` SET mem_username = '" . $_REQUEST['mem_username'] . "', mem_password = '" . $_REQUEST['mem_password'] . "',mem_firstname = '" . $_REQUEST['mem_firstname'] . "',mem_lastname= '" . $_REQUEST['mem_lastname'] . "',mem_gender = '" . $_REQUEST['mem_gender'] . "',mem_title = '" . $_REQUEST['mem_title'] . "', mem_phone = '" . $_REQUEST['mem_phone'] . "' WHERE mem_id='" . $_REQUEST['mem_id'] . "'");
            echo 1;
            break;
        case 'new_sale':
            if ($meu->check_username($_REQUEST['mem_username'])->num_rows) {
                echo 0;
            } else {
                $meu->qty("INSERT INTO tb_member (`mem_username`,`mem_password`,`mem_firstname`,`mem_lastname`,`mem_gender`,`mem_title`,`mem_phone`,`mem_point`,`mem_status`,`last_login`) VALUES ('" . $_REQUEST['mem_username'] . "','" . $_REQUEST['mem_password'] . "','" . $_REQUEST['mem_firstname'] . "','" . $_REQUEST['mem_lastname'] . "','" . $_REQUEST['mem_gender'] . "','" . $_REQUEST['mem_title'] . "','" . $_REQUEST['mem_phone'] . "',0,2,now()) ");
                echo 1;
            }
            break;
    }
}
