<?php

include_once __DIR__."/clsCart.php";

class clsCartController {

    private clsCart $obj_clsCart;
    private string $product_id;
    private string $quantity;

//////////////////////////////////////
    function __construct(string $pProduct_id = "", string $pQuantity = "") {
        $this -> obj_clsCart = new clsCart();
        $this -> product_id = $pProduct_id;
        $this -> quantity = $pQuantity;
        
    }

/////////////////////////////////////
    public function tryAddToCart() {
        return $this -> obj_clsCart -> AddToCart($this -> product_id, $this -> quantity);
    }

/////////////////////////////////////
    public function tryGetCart() {
        
    }

//////////////////////////////////////
    public function tryDropCart() {
        
    }
}

?>