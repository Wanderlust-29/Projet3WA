<?php
require_once '../vendor/autoload.php';
require_once 'secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/Projet3wa/index.php';

// Récupérer les informations du panier (exemple simplifié)
session_start();
$cartItems = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];

// Préparer les articles pour Stripe
$lineItems = [];
foreach ($cartItems as $article) {
    // Vous devrez ajuster les clés et les valeurs en fonction de la structure de vos articles
    $lineItems[] = [
        'price_data' => [
            'currency' => 'eur',
            'product_data' => [
                'name' => $article['name'],
                // 'images' => [$article['image']->getUrl()],
            ],
            'unit_amount' => $article['price'] * 100, // Prix de l'article en centimes
        ],
        'quantity' => 1, // Quantité de cet article dans le panier
    ];
}

// Créer une session de paiement avec Stripe
$checkoutSession = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '?route=success',
    'cancel_url' => $YOUR_DOMAIN . '?route=cart',
]);

// Rediriger l'utilisateur vers la page de paiement de Stripe
header("HTTP/1.1 303 See Other");
header("Location: " . $checkoutSession->url);
?>
