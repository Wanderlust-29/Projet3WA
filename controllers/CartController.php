<?php

class CartController extends AbstractController
{

    public function cart(): void
    {
        $totalPrice = 0;
        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : null;
        $quantity = 0;
        $notify = [];

        $sm = new ShippingManager();
        $shipping_costs = $sm->findAll();

        if (!is_null($cart)) {
            foreach ($cart as &$article) {  // Utilisation de la référence pour modifier directement l'article dans le tableau
                if (isset($article['price'], $article['quantity'], $article['stock'])) {
                    $article['is_in_stock'] = $article['quantity'] < $article['stock'];
                    if (!$article['is_in_stock']) {
                    }
                    $quantity += $article['quantity']; // Incrémenter la quantité totale
                    $totalPrice += $article['price'] * $article['quantity'];
                }
            }
        }

        $this->render("pay/cart.html.twig", [
            "cart" => $cart,
            "totalPrice" => $totalPrice,
            "quantity" => $quantity,
            "shipping_costs" => $shipping_costs,
            "notify" => $notify
        ]);
    }


    public function addToCart(): void
    {
        // Récupérer l'identifiant de l'article envoyé par la requête POST
        $id = intval($_POST['article_id']);

        // Récupérer l'article correspondant à l'identifiant
        $am = new ArticleManager();
        $article = $am->findOne($id);

        // Initialiser le panier s'il n'existe pas encore dans la session
        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array("articles" => array());
        }

        // Vérifier si l'article est déjà dans le panier
        if (isset($_SESSION["cart"]["articles"][$id])) {
            // Incrémenter la quantité de l'article existant
            $_SESSION["cart"]["articles"][$id]['quantity'] += 1;
        } else {
            // Ajouter l'article au panier avec une quantité de 1
            $articleArray = $article->toArray();
            $articleArray['quantity'] = 1;
            $_SESSION["cart"]["articles"][$id] = $articleArray;
        }
        // Renvoyer le contenu du panier au format JSON après l'ajout
        $this->renderJson($_SESSION["cart"]);
    }

    public function deleteFromCart(): void
    {
        $id = !empty($_POST['article_id']) ? intval($_POST['article_id']) : null;
        $action = !empty($_POST['action']) ? $_POST['action'] : null;

        if (!is_null($id) && isset($_SESSION["cart"]["articles"][$id])) {
            if ($action === 'delete') {
                unset($_SESSION["cart"]["articles"][$id]);
            }
        }

        $this->renderJson([
            'articles' => $_SESSION["cart"]["articles"],
        ]);
    }

    public function updateQuantity(): void
    {
        $id = !empty($_POST['article_id']) ? intval($_POST['article_id']) : null;
        $action = !empty($_POST['action']) ? $_POST['action'] : null;

        if (!is_null($id) && isset($_SESSION["cart"]["articles"][$id])) {
            if ($action === 'increment') {
                $_SESSION["cart"]["articles"][$id]['quantity'] += 1;
            } elseif ($action === 'decrement') {
                if ($_SESSION["cart"]["articles"][$id]['quantity'] > 1) {
                    $_SESSION["cart"]["articles"][$id]['quantity'] -= 1;
                } else {
                    unset($_SESSION["cart"]["articles"][$id]);
                }
            }
        }

        $this->renderJson([
            'articles' => $_SESSION["cart"]["articles"],
        ]);
    }

    // public function getShippingCosts($name)
    // {
    //     // Mettre à jour la session avec le coût de livraison sélectionné
    //     unset($_SESSION['cart']['shipping_costs']);
    //     $_SESSION['cart']['shipping_costs'] = $shippingCosts[$shippingMethod];

    //     // Répondre avec le nouveau contenu du panier ou tout autre information pertinente
    //     $this->renderJson($_SESSION["cart"]);
    // }

    public function updateShippingCosts()
    {
        if (isset($_SESSION["cart"]) && isset($_POST['shipping-method'])) {
            // Assume 'shippingMethod' est envoyé via POST
            $shippingMethod = $_POST['shipping-method']; // valeur par défaut si non spécifié

            $sm  = new ShippingManager();
            $shipping = $sm->findOne($shippingMethod);

            // Mettre à jour la session avec le coût de livraison sélectionné
            unset($_SESSION['cart']['shipping_costs']);
            $_SESSION['cart']['shipping_costs'] = $shipping->toArray();

            // Répondre avec le nouveau contenu du panier ou tout autre information pertinente
            $this->renderJson($_SESSION["cart"]);
        } else {
            return null;
        }
    }

    public function success()
    {
        if (!isset($_SESSION["user"])) {
            // Redirect to 403 error page or login page
            return $this->render('default/403.html.twig', []);
        }

        $user = $_SESSION["user"];
        $id_user = $user->getId();

        $totalPrice = 0;

        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : [];
        if (!is_array($cart)) {
            $cart = [];
        }

        foreach ($cart as $article) {
            if (isset($article['price'])) {
                $price = (float) $article['price'];
                $quantity = isset($article['quantity']) ? (int) $article["quantity"] : 1;
                $totalPrice += $price * $quantity;
            }
        }

        $shippingId = null;
        $shippingCost = 0;

        if (isset($_SESSION['cart']['shipping_costs']) && is_array($_SESSION['cart']['shipping_costs'])) {
            $shipping = $_SESSION['cart']['shipping_costs'];
            $sm = new ShippingManager();
            $shippingId = $sm->findOne($shipping['id']);
            if ($shippingId !== null) {
                $shippingCost = $shipping['price'];
                $totalPrice += $shippingCost;
            } else {
                error_log('Shipping object not found for ID: ' . $shipping['id']);
            }
        } else {
            error_log('Shipping information is missing or invalid in the session.');
        }

        if ($shippingId === null) {
            // Redirect to 404 error page
            return $this->render('default/404.html.twig', []);
        }

        $order = new Order($id_user, date('Y-m-d'), "success", $shippingId, $totalPrice);

        $om = new OrderManager();
        $om->createOrder($order);
        $_SESSION["cart"] = [];

        return $this->render('pay/success.html.twig', []);
    }




    //Quitter stripe
    public function cancel()
    {
        return $this->render('pay/cart.html.twig', []);
    }
}
