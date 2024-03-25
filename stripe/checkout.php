<?php

require_once '../vendor/autoload.php';
require_once 'secrets.php';

\Stripe\Stripe::setApiKey($stripeSecretKey);
header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost/Projet3wa/index.php';
        
$checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [[
      'price' => 'price_1Ox5jYI8LnQyDT8tMbPyIgk1',
      'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '?route=success',
    'cancel_url' => $YOUR_DOMAIN . '?route=cancel',
  ]);
  
  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);
