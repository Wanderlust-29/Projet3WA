<?php
// charge l'autoload de composer
require "vendor/autoload.php";

session_start();

// charge le contenu du .env dans $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Utilise le Router
// require_once 'services/Router.php';

if(!isset($_SESSION["csrf-token"]))
{
    $tokenManager = new CSRFTokenManager();
    $token = $tokenManager->generateCSRFToken();
    $_SESSION["csrf-token"] = $token;
}

// $router = new Router();
// $router->handleRequest($_GET);

// use Cocur\Slugify\Slugify;
// $slugify = new Slugify();

// $mysqli = new mysqli("localhost", "root", "", "ryan");
// $sql = "SELECT o.order_id,a.id,a.price FROM orders_articles as o LEFT JOIN articles as a ON o.article_id = a.id";
// $result = $mysqli->query($sql);

// while($row = $result->fetch_assoc()) {
//     $oi = $row['order_id'];
//     $ai = $row['id'];
//     $price = $row['price'];
//     $sql = "UPDATE orders_articles SET item_price = '$price ' WHERE order_id = $oi AND article_id = $ai";
//     $mysqli->query($sql);
// }

use Pecee\SimpleRouter\SimpleRouter;

/* Load external routes file */
require_once 'services/RouterHelpers.php';
require_once 'services/RouterFront.php';
require_once 'services/RouterAdmin.php';
SimpleRouter::setDefaultNamespace('\Projet3wa\Controllers');
// Start the routing
SimpleRouter::start();