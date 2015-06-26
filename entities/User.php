<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author iRViNE

 *  */
require_once '/helper/DataProvider.php';

class User {

    var $id, $username, $password, $name, $email, $dob, $permission;

    function __construct($id, $username, $password, $name, $email, $dob, $permission) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
        $this->email = $email;
        $this->dob = $dob;
        $this->permission = $permission;
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getDob() {
        return $this->dob;
    }

    public function getPermission() {
        return $this->permission;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDob($dob) {
        $this->dob = $dob;
    }

    public function setPermission($permission) {
        $this->permission = $permission;
    }

    public function insert() {

        $str_username = str_replace("'", "''", $this->username);
        $str_name = str_replace("'", "''", $this->name);
        $str_email = str_replace("'", "''", $this->email);
        $enc_pwd = md5($this->password);
        $str_dob = date('Y-m-d H:i:s', $this->dob);

        $sql = "insert into Users (f_Username, f_Password, f_Name, f_Email, f_DOB, f_Permission) "
                . "values('$str_username', '$enc_pwd', '$str_name', '$str_email', '$str_dob', $this->permission)";

        //echo $sql;

        DataProvider::execQuery($sql);
    }

    public function login() {
        $ret = false;

        $str_username = str_replace("'", "''", $this->username);
        $enc_pwd = md5($this->password);
        $sql = "select * from Users where f_Username='$str_username' and f_Password='$enc_pwd'";
        $list = DataProvider::execQuery($sql);

        if ($row = mysql_fetch_array($list)) {

            $this->id = $row["f_ID"];
            //$this->username = $row["f_Username"];
            //$this->password = $row["f_Password"];
            $this->name = $row["f_Name"];
            $this->email = $row["f_Email"];
            $this->dob = strtotime($row["f_DOB"]);
            $this->permission = $row["f_Permission"];

            $ret = true;
        }

        return $ret;
    }

    public static function changePassword($username, $pwd, $newPwd) {

        $enc_pwd = md5($pwd);
        $enc_new_pwd = md5($newPwd);

        $sql = "update Users set f_Password = '$enc_new_pwd' "
                . "where f_Username = '$username' and f_Password = '$enc_pwd'";

        return DataProvider::execNonQueryAffectedRows($sql);
    }

    public static function getInfo($username) {
        $p = NULL;

        $sql = "select * from Users where f_Username='$username'";
        $list = DataProvider::execQuery($sql);
        if ($row = mysql_fetch_array($list)) {
            $p = new User(
                    $row["f_ID"], 
                    $username, "", 
                    $row["f_Name"], 
                    $row["f_Email"], 
                    strtotime($row["f_DOB"]), 
                    $row["f_Permission"]
            );
        }

        return $p;
    }

}
