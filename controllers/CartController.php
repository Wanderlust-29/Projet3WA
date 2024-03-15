<?php

class CartController extends AbstractController
{
    public function showCart()
    {   
        $cm = new CartManager();
        $cart = $cm->getCart();
    
        $totalPrice = 0;
        foreach ($cart->getItems() as $item) {
            $totalPrice += $item->getPrice(); 
        }
        
        return $this->render('pages/cart.html.twig', [
            'cart' => $cart,
            'totalPrice' => $totalPrice, 
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
            $this->redirect("index.php?route=article&id=$itemId");
        }else{
            $_SESSION["error-message"] = "Erreur lors de l'ajout au panier";
            $this->redirect("index.php");
        }
    }
}
