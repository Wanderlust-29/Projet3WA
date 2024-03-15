<?php

class CartController extends AbstractController
{
    public function showCart()
    {   
        $cm = new CartManager();
        $cart = $cm->getCart();
    
        return $this->render('pages/cart.html.twig', [
            'cart' => $cart,
        ]);
    }

    public function addToCart($itemId)
    {
        $am = new ArticleManager();
        $article = $am->findOne($itemId);
        if ($article) {
            $cm = new CartManager();
            $cart = $cm->getCart(); 

            $cart->addItem($article);

            $cm->saveCart($cart);
        }else{

        }
    }
}
