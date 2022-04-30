<?php

include("DatabaseClass.php");
class MangeUserClass extends DatabaseClass
{
    //public $month = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
    //status = 2 -> admin 
    //status = 1 -> customer
    public function __construct()
    {
        DatabaseClass::__construct();
    }

    public function check_username($username) ///check user 
    {
        $sql = $this->qty("SELECT * FROM tb_member WHERE tb_member.mem_username='" . $username . "' ");;
        $this->qty("UPDATE tb_member SET last_login = now() WHERE mem_id = '" . $sql->fetch_object()->mem_id . "'");
        return $sql;
    }

    public function setSes_id() ///set session_id
    {
        $_SESSION['ses_id'] = session_id();
    }
    public function setSes_Status($status) /// set สถานะadmin customer
    {
        $this->setSes_id();
        $_SESSION['ses_status'] = $status;
        return 1;
    }

    public function check_login($username, $password) ///n check email and pass & set status
    {
        $ck_login = $this->qty("SELECT * FROM tb_member WHERE tb_member.mem_username = '" . $username . "' AND tb_member.mem_password = '" . $password . "'");
        if ($ck_login->num_rows) {
            $fet = $ck_login->fetch_object();
            $this->setSes_Status($fet->mem_status);
            $_SESSION['ses_mem_id'] = $fet->mem_id;
            $_SESSION['ses_id'] = session_id();
            $_SESSION['ses_cart'] = [];
            return 1;
        } else {
            $this->setSes_Status(0);
            return 0;
        }
    }

    public function forgot_password($username, $phone, $password) ////! check pass and new pass
    {
        $id = $this->qty("SELECT * FROM tb_member WHERE tb_member.mem_username = '" . $username . "' AND tb_member.mem_phone = '" . $phone . "'");
        if ($id->num_rows) {
            $this->qty("UPDATE `tb_member` SET `mem_password`='" . $password . "' WHERE `mem_id`= '" . $id->fetch_object()->mem_id . "'");
            return  1;
        } else {
            return 0;
        }
    }

    public function del($id)
    {
        $this->qty("DELETE FROM tb_member WHERE mem_id = '" . $id . "'");
        return 1;
    }

    public function edit_user($id)
    {

        $fet =  $this->qty("SELECT * FROM tb_member WHERE mem_id = '" . $id . "'")->fetch_object();
        $data = [$fet->mem_id, $fet->mem_username, $fet->mem_firstname, $fet->mem_lastname, $fet->mem_phone, $fet->mem_title, $fet->mem_gender, $fet->mem_password];
        echo json_encode($data);
    }
}
