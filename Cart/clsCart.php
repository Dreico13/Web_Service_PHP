<?php

include_once("/opt/lampp/htdocs/COM/DbUtils/clsControllerDB.php");

class clsCart {

    private clsControllerDb $obj_clsControllerDB;
    private string $product_id;
    private string $quantity;
    private string $conn_guid;

    //////////////////////////////////////////////////////////////
    public function AddToCart($pProduct_id,$pQuantity) {
        $this -> product_id = $pProduct_id;
        $this -> quantity = $pQuantity;
        $this -> conn_guid = urldecode($_COOKIE["token"]);
        $this -> obj_clsControllerDB = new clsControllerDb("sp_add_to_cart", [$this -> product_id , $this -> conn_guid , $this -> quantity]);
        return $this -> obj_clsControllerDB -> getResponseFromDB();
    }

    /////////////////////////////////////////////////////////////
    public function GetCart() {

    }
    ////////////////////////////////////////////////////////////
    public function DropCart() {

    }
}

?>