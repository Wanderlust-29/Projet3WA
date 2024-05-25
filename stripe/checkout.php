<?php
require_once '../vendor/autoload.php';
require_once __DIR__ . '/secret.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://projet3wa.local/';

// Récupérer les informations du panier (exemple simplifié)
session_start();
$cartItems = isset($_SESSION["cart"]['articles']) ? $_SESSION["cart"]['articles'] : [];
$shipping = isset($_SESSION["cart"]['shipping_costs']) ? $_SESSION["cart"]['shipping_costs'] : [];


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
        'quantity' => $article['quantity'], // Quantité de cet article dans le panier
    ];
}

// Créer une session de paiement avec Stripe
$checkoutSession = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'line_items' => $lineItems,
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . 'success',
    'cancel_url' => $YOUR_DOMAIN . 'cart',
    'shipping_options' => [
        [
            'shipping_rate_data' => [
                "type" => "fixed_amount",
                "fixed_amount" => [
                    "amount" => $shipping['price'] * 100,
                    "currency" => "eur"
                ],
                'display_name' => $shipping['name'],
                'delivery_estimate' => [
                    'minimum' => [
                        'unit' => 'business_day',
                        'value' => $shipping['delivery_min'],
                    ],
                    'maximum' => [
                        'unit' => 'business_day',
                        'value' => $shipping['delivery_max'],
                    ]
                ]
            ],
        ]
    ]
]);

// Rediriger l'utilisateur vers la page de paiement de Stripe
header("HTTP/1.1 303 See Other");
header("Location: " . $checkoutSession->url);
