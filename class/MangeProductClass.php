<?php

include("DatabaseClass.php");
class MangeProductClass extends DatabaseClass
{
    public function __construct()
    {
        DatabaseClass::__construct();
    }

    public function check_qty($data, $table, $name)
    {
        return  $this->qty("SELECT * FROM " . $table . " WHERE " . $name . " = " . "'" . $data  . "'")->num_rows;
    }


    public function pro_qty($data, $table, $name, $qty, $name_id, $id)
    {

        if ($qty == "add") {
            //
            if (($this->check_qty($data, $table, $name)) || $data == '') {
                return 0;
            } else {
                $this->qty("INSERT INTO " . $table . " ( " . $name . " ) VALUES ( " . "'" . "$data" . "'" . ")");
                return 1;
            }
        } else if ($qty == "update") {
            $this->qty("UPDATE " . $table . " SET " . $name . " = " . "'" . "$data" . "'" . " WHERE " . "$name_id" . " = " . "$id");
            return 2;
        } else if ($qty == "del") {;
            $this->qty("DELETE FROM " . $table . " WHERE " . $name . " = " . "$data");
            return 1;
        } else if ($qty == "select") {
            return $this->qty("SELECT * FROM " . "$table" . " WHERE " . "$name" . " = " . "$data");
        }
    }

}
