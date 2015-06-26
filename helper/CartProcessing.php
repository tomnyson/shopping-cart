<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CartProcessing
 *
 * @author iRViNE
 */
class CartProcessing {

    public static function addItem($masp, $solg) {
        // $a["SP0001"] = 5;
        // $a["SP0003"] = 15;
        if (array_key_exists($masp, $_SESSION['Cart'])) {
            $_SESSION['Cart'][$masp] += $solg;
        } else {
            $_SESSION['Cart'][$masp] = $solg;
        }
    }

    public static function countQuantity() {
        $ret = 0;
        foreach ($_SESSION['Cart'] as $masp => $solg) {
            $ret += $solg;
        }

        return $ret;
    }

    public static function removeItem($proId) {
        foreach ($_SESSION['Cart'] as $key => $val) {
            if ($key == $proId) {
                unset($_SESSION['Cart'][$key]);
                return;
            }
        }
    }

    public static function updateItem($proId, $quantity) {
        foreach ($_SESSION['Cart'] as $key => $val) {
            if ($key == $proId) {
                $_SESSION['Cart'][$key] = $quantity;
                return;
            }
        }
    }

}
