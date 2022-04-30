<?php
include("DatabaseClass.php");
class MangeOrderClass extends DatabaseClass
{
    public function __construct()
    {
        DatabaseClass::__construct();
    }

    public function add_order($order)
    {
        $this->qty("INSERT INTO tb_order (`mem_id`,`order_date`,`date_tranfer`,`order_total`,`money`,`pay_status`,`bank_id`,`bank_img`) VALUES (0,now(),now(),'" . $order[1] . "','" . $order[2] . "''1',0,'ชำระเงินสด')");
        $order_id = $this->qty("SELECT MAX(order_id) FROM `tb_order`")->fetch_array()[0];
        for ($i = 0; $i < count($order[0]); $i++) {
            $this->qty("INSERT INTO tb_order_item (`order_id`,`pro_id`,`item_qty`, `pay_status`) VALUES ('" . $order_id . "','" . $order[0][$i]->pro_id . "','" . $order[0][$i]->amount . "',1)");
            $pro_pop = $this->qty("SELECT pro_pop FROM tb_product WHERE pro_id = '" . $order[0][$i]->pro_id . "'")->fetch_array()[0];
            $this->qty("UPDATE tb_product SET pro_pop = '" . $pro_pop + $order[0][$i]->amount . "' WHERE pro_id = '" . $order[0][$i]->pro_id . "'");
        }
        return json_encode([1, $order_id]);
    }

    public function add_cart($pro_id)
    {
        if (!isset($_SESSION['ses_inline'])) {
            $_SESSION['ses_inline'] = 0;
            $_SESSION['ses_amount'][0] = 1;
            $_SESSION['ses_cart'][0] = $pro_id;
        } else {
            if (isset($pro_id) != "") {
                $key = array_search($pro_id, $_SESSION['ses_cart']);
                if ((string)$key != "") {
                    $_SESSION['ses_amount'][$key] += 1;
                } else {
                    $_SESSION['ses_inline'] += 1;
                    $line = $_SESSION['ses_inline'];
                    $_SESSION['ses_amount'][$line] = 1;
                    $_SESSION['ses_cart'][$line] = $pro_id;
                }
            }
        }
        return  count($_SESSION['ses_cart']);
    }

    public function payment($file, $bank_id)
    {
        if (isset($file['name'])) {
            rename($file['tmp_name'], "../images/slips/" . $_SESSION['ses_mem_id'] . $file['name']);
            $this->qty("INSERT INTO tb_order (mem_id,order_date,date_tranfer,order_total,money,pay_status,bank_id,bank_img) VALUES ('" . $_SESSION['ses_mem_id'] . "',NOW(),NOW(),'" . $_SESSION['ses_total'] . "',0,0,'" . $bank_id . "','" . $_SESSION['ses_mem_id'] . $file['name'] . "')");
            $order_id = $this->qty("SELECT MAX(order_id) FROM tb_order WHERE mem_id = '" . $_SESSION['ses_mem_id'] . "'")->fetch_all();
            for ($i = 0; $i <= $_SESSION['ses_inline']; $i++) {
                if (isset($_SESSION['ses_cart'][$i]) != null) {
                    $this->qty("INSERT INTO tb_order_item (order_id,pro_id,item_qty,pay_status) VALUES ('" . $order_id[0][0] . "','" . $_SESSION['ses_cart'][$i] . "','" . $_SESSION['ses_amount'][$i] . "',0)");
                    $this->qty("UPDATE tb_product SET pro_pop = pro_pop + 1  WHERE pro_id = '" . $_SESSION['ses_cart'][$i] . "'");
                }
            }
            $this->qty("UPDATE tb_member SET mem_point = mem_point + 1 WHERE mem_id = '" . $_SESSION['ses_mem_id'] . "'");
            echo "<script>window.location.replace('../index.php?p=get_product')</script>";
            $_SESSION['ses_cart'] = [];
            unset($_SESSION['ses_amount']);
            unset($_SESSION['ses_line']);
        }
    }

    public function confirm_payment($order_id)
    {
        $this->qty("UPDATE tb_order SET pay_status = 1  WHERE order_id = '" . $order_id . "'");
        return 1;
    }
    public function get_product($item_id)
    {
        $this->qty("UPDATE tb_order_item SET pay_status = 1  WHERE item_id = '" . $item_id . "'");
        echo 1;
    }
    public function sort_date($start, $end)
    {
        $this->qty("SELECT * FROM tb_order WHERE order_date BETWEEN '" . $start . "' AND '" . $end . "'");
    }
}
