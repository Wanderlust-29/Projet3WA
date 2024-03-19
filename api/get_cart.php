<?php
// Démarre la session si ce n'est pas déjà fait
session_start();

// Récupérer les éléments du panier à l'aide du manager
$cm = new CartManager;
$cm->getCartItemsAsArray();


// Encoder en JSON et afficher les éléments du panier
echo json_encode($cartItemsArray);
?>