<?php


session_start();
include("../class/MangeOrderClass.php");
$order = new MangeOrderClass();

if (isset($_REQUEST['ac'])) {

    switch ($_REQUEST['ac']) {
        case 'add_order':
            echo  $order->add_order(json_decode($_REQUEST['order']));
            break;
        case 'i_order':
            echo $order->add_cart($_REQUEST['order']);
            break;
        case 'payment':
            $order->payment($_FILES['bank_img'], $_REQUEST['bank_id']);
            break;
        case 'confirm_pay':
            echo $order->confirm_payment($_REQUEST['order_id']);
            break;
        case 'get_pro':
            echo $order->get_product($_REQUEST['item_id']);
            break;
    }
}
