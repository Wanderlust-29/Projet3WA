<?php

class CartManager
{
    public function getCart()
    {
        if(isset($_SESSION['cart'])) {
            return $_SESSION['cart'];
        } else {
            $cart = new Cart();
            $_SESSION['cart'] = $cart;
            return $cart;
        }
    }

    public function saveCart($cart)
    {
        $_SESSION['cart'] = $cart;
    }
}
