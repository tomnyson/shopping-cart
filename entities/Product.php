<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Product
 *
 * @author iRViNE
 */
class Product {

    var $proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId;

    function __construct($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId) {
        $this->proId = $proId;
        $this->proName = $proName;
        $this->tinyDes = $tinyDes;
        $this->fullDes = $fullDes;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->catId = $catId;
    }

    public function getProId() {
        return $this->proId;
    }

    public function getProName() {
        return $this->proName;
    }

    public function getTinyDes() {
        return $this->tinyDes;
    }

    public function getFullDes() {
        return $this->fullDes;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getCatId() {
        return $this->catId;
    }

    public function setProId($proId) {
        $this->proId = $proId;
    }

    public function setProName($proName) {
        $this->proName = $proName;
    }

    public function setTinyDes($tinyDes) {
        $this->tinyDes = $tinyDes;
    }

    public function setFullDes($fullDes) {
        $this->fullDes = $fullDes;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setCatId($catId) {
        $this->catId = $catId;
    }

    public static function loadProductsByCatId($p_catId) {
        $ret = array();

        $sql = "select * from products where CatID = $p_catId";
        $list = DataProvider::execQuery($sql);

        while ($row = mysql_fetch_array($list)) {
            $proId = $row["ProID"];
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            //$catId = $row["CatID"];
            $catId = $p_catId;

            $p = new Product($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId);
            array_push($ret, $p);
        }

        return $ret;
    }

    public static function loadProductByProId($p_proId) {
        $sql = "select * from products where ProID = $p_proId";
        $list = DataProvider::execQuery($sql);

        if ($row = mysql_fetch_array($list)) {

            //$proId = $row["ProID"];
            $proId = $p_proId;
            $proName = $row["ProName"];
            $tinyDes = $row["TinyDes"];
            $fullDes = $row["FullDes"];
            $price = $row["Price"];
            $quantity = $row["Quantity"];
            $catId = $row["CatID"];

            $p = new Product($proId, $proName, $tinyDes, $fullDes, $price, $quantity, $catId);
            return $p;
        }

        return NULL;
    }

}
