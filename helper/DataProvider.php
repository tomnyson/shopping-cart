<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataProvider
 *
 * @author iRViNE
 */
define("SERVER", "localhost");
define("DB", "qlbh");
define("UID", "root");
define("PWD", "");

class DataProvider {

    public static function execQuery($sql) {
        $cn = mysql_connect(SERVER, UID, PWD) or
                die("Không thể kết nối vào máy chủ");

        mysql_select_db(DB, $cn);
        mysql_query("set names 'utf8'");

        $kq = mysql_query($sql, $cn);
        if (!$kq)
            die("Lỗi truy vấn: " . mysql_error());

        mysql_close($cn);
        return $kq;
    }

    public static function execNonQueryAffectedRows($sql) {
        $cn = mysql_connect(SERVER, UID, PWD) or
                die("Không thể kết nối vào máy chủ");

        mysql_select_db(DB, $cn);
        mysql_query("set names 'utf8'");

        if (!mysql_query($sql, $cn))
            die("Lỗi truy vấn: " . mysql_error());

        $affected_rows = mysql_affected_rows();
        mysql_close($cn);

        return $affected_rows;
    }

    public static function execNonQueryIdentity($sql) {
        $cn = mysql_connect(SERVER, UID, PWD) or
                die("Không thể kết nối vào máy chủ");

        mysql_select_db(DB, $cn);
        mysql_query("set names 'utf8'");

        if (!mysql_query($sql, $cn))
            die("Lỗi truy vấn: " . mysql_error());

        $id = mysql_insert_id();
        mysql_close($cn);

        return $id;
    }

}
