<?php
include("../class/MangeProductClass.php");
$mep = new MangeProductClass();

if (isset($_REQUEST['ac'])) {
    switch ($_REQUEST['ac']) {
        case 'add_cate':
            if ($_REQUEST['type'] == "add") {
                echo $mep->pro_qty($_REQUEST['cate_name'], "tb_category", "cate_name", "add", "", "");
            } else if ($_REQUEST['type'] == "update") {
                echo $mep->pro_qty($_REQUEST['cate_name'], "tb_category", "cate_name", "update", "cate_id", $_REQUEST['id']);
            }
            break;
        case 'del_cate':
            echo $mep->pro_qty($_REQUEST['cate_id'], "tb_category", "cate_id", "del", "", "");
            break;
        case 'edit_cate':
            echo $mep->pro_qty($_REQUEST['cate_id'], "tb_category", "cate_id", "select", null, null)->fetch_object()->cate_name;
            break;
        case 'add_unit':
            if ($_REQUEST['type'] == "add") {
                echo $mep->pro_qty($_REQUEST['unit_name'], "tb_unit", "unit_name", "add", "", "");
            } else if ($_REQUEST['type'] == "update") {
                echo $mep->pro_qty($_REQUEST['unit_name'], "tb_unit", "unit_name", "update", "unit_id", $_REQUEST['id']);
            }
            break;
        case 'edit_unit':
            echo $mep->pro_qty($_REQUEST['unit_id'], "tb_unit", "unit_id", "select", null, null)->fetch_object()->unit_name;
            break;
        case 'del_unit':
            echo $mep->pro_qty($_REQUEST['unit_id'], "tb_unit", "unit_id", "del", "", "");
            break;
        case 'add_bank':
            if ($_REQUEST['type'] == "add") {
                if ($mep->qty("INSERT INTO tb_bank (bank_name,bank_username,bank_number) VALUES ('" . $_REQUEST['bank_name'] . "' , '" . $_REQUEST['bank_username'] . "' , '" . $_REQUEST['bank_number'] . "')")) {
                    echo 1;
                }
            } else if ($_REQUEST['type'] == "update") {
                echo $mep->pro_qty($_REQUEST['bank_name'], "tb_bank", "bank_name", "update", "bank_id", $_REQUEST['id']);
            }
            break;
        case 'edit_bank':
            echo json_encode($mep->pro_qty($_REQUEST['bank_id'], "tb_bank", "bank_id", "select", null, null)->fetch_all());
            break;
        case 'del_bank':
            echo $mep->pro_qty($_REQUEST['bank_id'], "tb_bank", "bank_id", "del", "", "");
            break;
        case 'add_pro':
            if ($mep->check_qty($_REQUEST['pro_name'], "tb_product", "pro_name")) {
            } else {
                if (isset($_FILES['pro_img']['name'])) {
                    copy($_FILES['pro_img']['tmp_name'], "../images/products/" . $_FILES['pro_img']['name']);
                    $mep->qty("INSERT INTO tb_product (`pro_name`,`pro_code`,`pro_price`,`pro_unit_id`,`pro_description1`,`pro_description2`,`pro_category_id`,`pro_img`,`pro_pop`) VALUE ('" . $_REQUEST['pro_name'] . "','" . $_REQUEST['pro_code'] . "','" . $_REQUEST['pro_price'] . "','" . $_REQUEST['pro_unit_id'] . "','" . $_REQUEST['pro_description1'] . "','" . $_REQUEST['pro_description2'] . "','" . $_REQUEST['pro_category_id'] . "','" . $_FILES['pro_img']['name'] . "',0)");
                    echo "<script>window.location.replace('../index.php?p=product');</script>";
                }
            }
            break;
        case 'search':
            echo json_encode($mep->qty("SELECT * FROM tb_product WHERE pro_name LIKE '" . $_REQUEST['keyword'] . "' OR pro_category_id LIKE '" . $_REQUEST['keyword'] . "'")->fetch_all());
            break;
        case 'cate':
            echo $_REQUEST['cate_n'];
            break;
        case 'select_pro':
            $get = $mep->qty("SELECT * FROM tb_product WHERE tb_product.pro_id = '" . $_REQUEST['pro_id'] . "'")->fetch_object();
            $arr = array("pro_id" => $get->pro_id, "pro_name" => $get->pro_name, "pro_code" => $get->pro_code, "pro_price" => $get->pro_price, "pro_unit_id" => $get->pro_unit_id, "pro_cate_id" => $get->pro_category_id, "pro_description1" => $get->pro_description1, "pro_description2" => $get->pro_description2, "pro_img" => $get->pro_img);
            echo json_encode($arr);
            break;
        case 'edit_pro':
            $fet =  $mep->qty("SELECT * FROM tb_product WHERE pro_id = '" . $_REQUEST['pro_id'] . "'")->fetch_object();
            if (isset($_FILES['edit_pro_img']['name'])) {
                if ($_FILES['edit_pro_img']['size'] == 0) {
                    $mep->qty("UPDATE tb_product SET pro_name = '" . $_REQUEST['edit_pro_name'] . "',pro_code = '" . $_REQUEST['edit_pro_code'] . "', pro_price = '" . $_REQUEST['edit_pro_price'] . "',pro_unit_id = '" . $_REQUEST['edit_pro_unit'] . "',pro_description1= '" . $_REQUEST['edit_pro_description1'] . "',pro_description2= '" . $_REQUEST['edit_pro_description2'] . "',pro_category_id= '" . $_REQUEST['edit_pro_cate'] . "' WHERE pro_id = '" . $_REQUEST['pro_id'] . "'");
                    echo "<script>window.location.replace('../index.php?p=product');</script>";
                } else {
                    unlink("../images/" . $fet->pro_img);
                    copy($_FILES['edit_pro_img']['tmp_name'], "../images/products/" . $_FILES['edit_pro_img']['name']);
                    $mep->qty("UPDATE tb_product SET pro_name = '" . $_REQUEST['edit_pro_name'] . "',pro_code = '" . $_REQUEST['edit_pro_code'] . "', pro_price = '" . $_REQUEST['edit_pro_price'] . "',pro_unit_id = '" . $_REQUEST['edit_pro_unit'] . "',pro_description1= '" . $_REQUEST['edit_pro_description1'] . "',pro_description2= '" . $_REQUEST['edit_pro_description2'] . "',pro_category_id= '" . $_REQUEST['edit_pro_cate'] . "', pro_img = '" . $_FILES['edit_pro_img']['name'] . "' WHERE pro_id = '" . $_REQUEST['pro_id'] . "'");
                    echo "<script>window.location.replace('../index.php?p=product');</script>";
                }
            }
            break;
        case 'del_pro':
            unlink("../images/products/" . $mep->pro_qty($_REQUEST['pro_id'], "tb_product", "pro_id", "select", "", "")->fetch_object()->pro_img);
            echo $mep->pro_qty($_REQUEST['pro_id'], "tb_product", "pro_id", "del", "", "");
            break;
        case 'add_pm':
            if (isset($_FILES['pm_img']['name'])) {
                copy($_FILES['pm_img']['tmp_name'], "../images/promotions/" . $_FILES['pm_img']['name']);
                $mep->qty("INSERT INTO tb_promotion (`pm_img`) VALUE ('" . $_FILES['pm_img']['name'] . "')");
                echo "<script>window.location.replace('../index.php?p=promotion');</script>";
            }
            break;
        case 'del_pm':
            unlink("../images/promotions/" . $mep->pro_qty($_REQUEST['pm_id'], "tb_promotion", "pm_id", "select", "", "")->fetch_object()->pm_img);
            echo $mep->pro_qty($_REQUEST['pm_id'], "tb_promotion", "pm_id", "del", "", "");
            break;
    }
}
