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
    public function delete($cart, $itemId)
    {
        $items = $cart->getItems(); 
        foreach ($items as $key => $item) {
            if ($item->getId() == $itemId) { 
                unset($items[$key]); 
                $cart->setItems($items);
                $this->saveCart($cart); 
                return true; 
            }
        }
        return false;
    }
}
