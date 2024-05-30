<?php
use \Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', [DefaultController::class, 'home'])->name('home');
SimpleRouter::get('/articles', [PageController::class, 'articles']);
SimpleRouter::get('/categorie/{slug}', [PageController::class, 'category'])->setSettings(['includeSlash' => false]);
SimpleRouter::get('/article/{slug}', [PageController::class, 'article'])->setSettings(['includeSlash' => false]);
SimpleRouter::get('/articles-search', [PageController::class, 'search'])->setSettings(['includeSlash' => false]);

SimpleRouter::get('/login', [AuthController::class, 'login']);
SimpleRouter::post('/check-login', [AuthController::class, 'checkLogin']);
SimpleRouter::get('/register', [AuthController::class, 'register']);
SimpleRouter::post('/check-register', [AuthController::class, 'checkRegister']);
SimpleRouter::match(['get', 'post'],'/logout', [AuthController::class, 'logout']);

SimpleRouter::get('/account', [AccountController::class, 'account']);
SimpleRouter::post('/update', [AccountController::class, 'updateUserProfile']);

SimpleRouter::get('/contact', [PageController::class, 'contact'])->setSettings(['includeSlash' => false]);
SimpleRouter::get('/adopt', [PageController::class, 'adopt'])->setSettings(['includeSlash' => false]);
SimpleRouter::post('/contact-check', [PageController::class, 'contactCheck'])->setSettings(['includeSlash' => false]);
SimpleRouter::get('/conditions', [PageController::class, 'conditions'])->setSettings(['includeSlash' => false]);
SimpleRouter::get('/legal', [PageController::class, 'legal'])->setSettings(['includeSlash' => false]);
SimpleRouter::get('/privacy', [PageController::class, 'privacy'])->setSettings(['includeSlash' => false]);
SimpleRouter::get('/refund', [PageController::class, 'refund'])->setSettings(['includeSlash' => false]);

SimpleRouter::match(['get', 'post'],'/cart', [CartController::class, 'cart'])->setSettings(['includeSlash' => false]);
SimpleRouter::post('/add-to-cart', [CartController::class, 'addToCart']);
SimpleRouter::post('/delete-from-cart', [CartController::class, 'deleteFromCart']);
SimpleRouter::get('/success', [CartController::class, 'success']);
SimpleRouter::post('/update-shipping-costs', [CartController::class, 'updateShippingCosts']);
SimpleRouter::get('/stripe/checkout', [CartController::class, 'updateShippingCosts']);

//if($route === "comment") 
SimpleRouter::post('/new-comment', [CartController::class, 'deleteFromCart']);
//if($route === "check-comment") 
SimpleRouter::post('/check-comment', [CartController::class, 'deleteFromCart']);


// SimpleRouter::error(function(Request $request, \Exception $exception) {
//     switch($exception->getCode()) {
//         // Page not found
//         case 404:
//             response()->redirect('/not-found');
//         // Forbidden
//         case 403:
//             response()->redirect('/forbidden');
//     }
// });