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
// $mysqli = new mysqli("db.3wa.io", "ryanroudaut", "d5eb7817da268ddd4f55484fc69f8474", "ryanroudaut_projet");
// $sql = "SELECT id, name FROM articles";
// $result = $mysqli->query($sql);

// while($row = $result->fetch_assoc()) {
//     $slug = $slugify->slugify($row['name']);
//     $id = $row['id'];
//     $sql = "UPDATE articles SET slug = '$slug' WHERE id = $id";
//     $mysqli->query($sql);
// }
// die();

use Pecee\SimpleRouter\SimpleRouter;


/* Load external routes file */
require_once 'services/RouterHelpers.php';
require_once 'services/RouterBis.php';

/**
 * The default namespace for route-callbacks, so we don't have to specify it each time.
 * Can be overwritten by using the namespace config option on your routes.
 */

SimpleRouter::setDefaultNamespace('\Demo\Controllers');

// Start the routing
SimpleRouter::start();