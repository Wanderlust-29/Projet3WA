<?php

class CartController extends AbstractController
{
    public function showCart()
    {   
        $success = isset($_SESSION["success-message"]) ? $_SESSION["success-message"] : null;
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
        $cm = new CartManager();
        $cart = $cm->getCart();

        // Utilisez la méthode getItems() pour accéder aux articles du panier
        $items = $cart->getItems();
        // Nombre d'articles dans le panier
        $count = count($items);
        dump($_SESSION["cart"]->getItems());


        $totalPrice = 0;
        foreach ($cart->getItems() as $item) {
            $totalPrice += $item->getPrice(); 
        }
        
        return $this->render('pages/cart.html.twig', [
            'cart' => $cart,
            'totalPrice' => $totalPrice, 
            'success' => $success,
            'error' => $error,
            'session' => $session
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
            $_SESSION["success-message"] = "L'article a été ajouté au panier.";
        }else{
            $_SESSION["error-message"] = "Erreur lors de l'ajout au panier";
            $this->redirect("index.php");
        }
    }
    public function deleteFromCart()
    {
        
        $itemId = $_POST['itemId'];
        $cm = new CartManager();
        $cart = $cm->getCart();
    
        $success = $cm->delete($cart, $itemId);
    
        if ($success) {
            $_SESSION["success-message"] = "L'article a été supprimé du panier avec succès.";
        } else {
            $_SESSION["error-message"] = "Erreur lors de la suppression de l'article du panier.";
        }
    
        $this->redirect("index.php?route=cart");
    }
    
}
