<?php

class CartController extends AbstractController
{
    /**
     * Renders the cart page with cart items, total price, quantity, shipping costs, and notifications.
     */
    public function cart(): void
    {
        $totalPrice = 0;
        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : null;
        $quantity = 0;
        $notify = [];

        $sm = new ShippingManager();
        $shipping_costs = $sm->findAll();

        if (!is_null($cart)) {
            foreach ($cart as &$article) {
                if (isset($article['price'], $article['quantity'], $article['stock'])) {
                    $article['is_in_stock'] = $article['quantity'] < $article['stock'];
                    $quantity += $article['quantity'];
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

    /**
     * Adds an article to the shopping cart.
     * Returns the updated cart in JSON format.
     */
    public function addToCart(): void
    {
        $id = intval($_POST['article_id']);
        $am = new ArticleManager();
        $article = $am->findOne($id);

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = array("articles" => array());
        }

        if (isset($_SESSION["cart"]["articles"][$id])) {
            $_SESSION["cart"]["articles"][$id]['quantity'] += 1;
        } else {
            $articleArray = $article->toArray();
            $articleArray['quantity'] = 1;
            $_SESSION["cart"]["articles"][$id] = $articleArray;
        }

        $this->renderJson($_SESSION["cart"]);
    }

    /**
     * Deletes an article from the shopping cart.
     * Returns the updated cart in JSON format.
     */
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

    /**
     * Updates the quantity of an article in the shopping cart.
     * Returns the updated cart in JSON format.
     */
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

    /**
     * Updates the shipping costs in the cart session based on selected shipping method.
     * Returns the updated cart in JSON format.
     */
    public function updateShippingCosts()
    {
        if (isset($_SESSION["cart"]) && isset($_POST['shipping-method'])) {
            $shippingMethod = $_POST['shipping-method'];
            $sm  = new ShippingManager();
            $shipping = $sm->findOne($shippingMethod);

            unset($_SESSION['cart']['shipping_costs']);
            $_SESSION['cart']['shipping_costs'] = $shipping->toArray();

            $this->renderJson($_SESSION["cart"]);
        } else {
            return null;
        }
    }

    /**
     * Handles the success page after completing an order.
     * Creates an order in the database and clears the cart session.
     */
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

    /**
     * Cancels the checkout process and returns to the cart page.
     */
    public function cancel()
    {
        return $this->render('pay/cart.html.twig', []);
    }
}
