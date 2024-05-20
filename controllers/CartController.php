<?php

class CartController extends AbstractController
{

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
    
    public function deleteFromCart() : void
    {
        // Récupère l'identifiant de l'article à supprimer envoyé par la requête POST
        $id = !empty($_POST['article_id']) ? intval($_POST['article_id']) : null;
        
        // Vérifie si le panier existe dans la session
        if (isset($_SESSION["cart"])) {
            if(is_null($id)){
                unset($_SESSION['cart']['shipping_costs']);
            }else{
                foreach ($_SESSION["cart"] as $key => $article) {
                    if ($article['id'] === $id) {
                        unset($_SESSION["cart"][$key]);
                        break; 
                    }
                }
            }
        }
        // Réindexe le tableau après la suppression d'un élément
        $_SESSION["cart"] = array_values($_SESSION["cart"]);
        // Renvoye le contenu du panier au format JSON après la suppression
        $this->renderJson($_SESSION["cart"]);
    }

    public function updateShippingCosts()
    {   
        if (isset($_SESSION["cart"])) {
            // Assume 'shippingMethod' est envoyé via POST
            $shippingMethod = $_POST['shipping-method'] ?? 'home'; // valeur par défaut si non spécifié
        
            // Vous pourriez avoir un tableau des coûts de livraison ou les récupérer d'une base de données
            $shippingCosts = [
                'udp' => ['price' => 11.99, 'name' => '2-3 jours ouvrés Udp'],
                'chronopost' => ['price' => 9.99, 'name' => 'Chronopost 4-5 jours ouvrés'],
                'home' => ['price' => 0.00, 'name' => 'Venir chercher sur place']
            ];
        }
        
        // Mettre à jour la session avec le coût de livraison sélectionné
        unset($_SESSION['cart']['shipping_costs']);
        $_SESSION['cart']['shipping_costs'] = $shippingCosts[$shippingMethod];
        
        // Répondre avec le nouveau contenu du panier ou tout autre information pertinente
        $this->renderJson($_SESSION["cart"]);
    }

    public function success()
    {   
        $user = $_SESSION["user"];
        $totalPrice = 0;
        $cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];
        $status = "success";
        
        foreach ($cart as $article) {
            if (isset($article['price'])) {
                $totalPrice += $article['price'];
            }
        }
        $order = new Order($user, date('Y-m-d'), $status, $totalPrice);
        
        $om = new OrderManager();
        $om->createOrder($order);
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
