<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author iRViNE
 */
require_once '/helper/DataProvider.php';

class Category {

    var $catId, $catName;

    function __construct($catId, $catName) {
        $this->catId = $catId;
        $this->catName = $catName;
    }

    public function getCatId() {
        return $this->catId;
    }

    public function getCatName() {
        return $this->catName;
    }

    public function setCatId($catId) {
        $this->catId = $catId;
    }

    public function setCatName($catName) {
        $this->catName = $catName;
    }

    // Lấy danh sách danh mục đang có trong CSDL
    public static function loadAll() {
        $ret = array();

//        $c1 = new Category(1, "a");
//        $c2 = new Category(2, "b");
//        $c3 = new Category(3, "c");
//        
//        array_push($ret, $c1);
//        array_push($ret, $c2);
//        array_push($ret, $c3);
        
        $sql = "select * from categories";
        $list = DataProvider::execQuery($sql);

        while ($row = mysql_fetch_array($list)) {
            $id = $row["CatID"];
            $name = $row["CatName"];
            $c = new Category($id, $name);
            
            array_push($ret, $c);
        }

        return $ret;
    }

}
