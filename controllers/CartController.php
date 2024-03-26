<?php

class CartController extends AbstractController
{
    public function addToCart() : void
    {
        // Récupérer l'identifiant de l'article envoyé par la requête POST
        $id = intval($_POST['article_id']);
        
        // Récupérer l'article correspondant à l'identifiant
        $am = new ArticleManager();
        $article = $am->findOne($id);
        
        // Initialiser le panier s'il n'existe pas encore dans la session
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array();
        }
        
        // Ajouter l'article au panier
        $_SESSION["cart"][] = $article->toArray();
        
        // Renvoyer le contenu du panier au format JSON après l'ajout
        $this->renderJson($_SESSION["cart"]);
    }
    
    
    public function cart() : void
    {
        $totalPrice = 0;
        $cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];
        
        foreach ($cart as $article) {
            if (isset($article['price'])) {
                $totalPrice += $article['price'];
            }
        }

        $this->render("pay/cart.html.twig", [
            "cart" => $cart,
            "totalPrice" => $totalPrice,
        ]);
    }

    public function deleteFromCart() : void
    {
        // Récupére l'identifiant de l'article à supprimer envoyé par la requête POST
        $id = intval($_POST['article_id']);
            
        // Vérifie si le panier existe dans la session
        if (isset($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $key => $article) {
                if ($article['id'] === $id) {
                    unset($_SESSION["cart"][$key]);
                    break; 
                }
            }
        }
        // Réindexe le tableau après la suppression d'un élément
        $_SESSION["cart"] = array_values($_SESSION["cart"]);
        // Renvoye le contenu du panier au format JSON après la suppression
        $this->renderJson($_SESSION["cart"]);
    }


    public function success()
    {   
        $om = new OrderManager();
        $om->createOrder();
        $_SESSION["cart"] = [];

        return $this->render('pay/success.html.twig', [
        ]);
    }
    
    public function cancel()
    {   
        return $this->render('pay/cart.html.twig', [
        ]);
    }
    
}
