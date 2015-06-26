<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order
 *
 * @author iRViNE
 */
class Order {

    var $orderID, $orderDate, $userID, $total;

    function __construct($orderID, $orderDate, $userID, $total) {
        $this->orderID = $orderID;
        $this->orderDate = $orderDate;
        $this->userID = $userID;
        $this->total = $total;
    }

    public function getOrderID() {
        return $this->orderID;
    }

    public function getOrderDate() {
        return $this->orderDate;
    }

    public function getUserID() {
        return $this->userID;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setOrderID($orderID) {
        $this->orderID = $orderID;
    }

    public function setOrderDate($orderDate) {
        $this->orderDate = $orderDate;
    }

    public function setUserID($userID) {
        $this->userID = $userID;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function add() {

        $str_order_date = date('Y-m-d H:i:s', $this->orderDate);

        $sql = "insert into Orders (OrderDate, UserID, Total)
                values ('$str_order_date', $this->userID , $this->total)";

        $this->orderID = DataProvider::execNonQueryIdentity($sql);
    }

}
