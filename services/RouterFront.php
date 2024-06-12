<?php

use \Pecee\SimpleRouter\SimpleRouter;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\Exceptions\HttpException;

// Routes articles
SimpleRouter::get('/', [DefaultController::class, 'home'])->name('home');
SimpleRouter::get('/articles', [PageController::class, 'articles'])->name('products');
SimpleRouter::get('/categorie/{slug}', [PageController::class, 'category'])->setSettings(['includeSlash' => false])->name('category');
SimpleRouter::get('/article/{slug}', [PageController::class, 'article'])->setSettings(['includeSlash' => false])->name('product');
SimpleRouter::post('/articles-search', [PageController::class, 'search'])->setSettings(['includeSlash' => false])->name('productSearch');
SimpleRouter::post('/sort-result-articles', [PageController::class, 'sort'])->setSettings(['includeSlash' => false])->name('productSort');
SimpleRouter::post('/sort-result-category', [PageController::class, 'sortByCategory'])->setSettings(['includeSlash' => false])->name('categorySort');

// Routes authentification
SimpleRouter::get('/login', [AuthController::class, 'login'])->name('login');
SimpleRouter::post('/check-login', [AuthController::class, 'checkLogin'])->name('checkLogin');
SimpleRouter::get('/register', [AuthController::class, 'register'])->name('register');
SimpleRouter::post('/check-register', [AuthController::class, 'checkRegister'])->name('checkRegister');
SimpleRouter::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

// Routes account
SimpleRouter::group(['middleware' => Projet3wa\Middlewares\AuthUser::class, 'prefix' => '/account'], function () {
    SimpleRouter::get('/', [AccountController::class, 'account'])->setSettings(['includeSlash' => false])->name('account');
    SimpleRouter::get('/infos', [AccountController::class, 'infos'])->setSettings(['includeSlash' => false])->name('infos');
    SimpleRouter::post('/update', [AccountController::class, 'updateUserProfile'])->name('updateUserProfile');
    SimpleRouter::post('/update-password', [AccountController::class, 'updateUserPassword'])->name('updateUserPassword');
    SimpleRouter::post('/delete', [AccountController::class, 'deleteUserProfile'])->name('deleteUserProfile');
    SimpleRouter::get('/orders', [AccountController::class, 'orders'])->setSettings(['includeSlash' => false])->name('userOrders');
    SimpleRouter::get('/orders/{id}', [AccountController::class, 'order'])->setSettings(['includeSlash' => false])->name('userOrder');
});

// Routes various pages
SimpleRouter::get('/contact', [PageController::class, 'contact'])->setSettings(['includeSlash' => false])->name('contact');
SimpleRouter::get('/adopt', [PageController::class, 'adopt'])->setSettings(['includeSlash' => false])->name('adopt');
SimpleRouter::post('/contact-check', [PageController::class, 'contactCheck'])->setSettings(['includeSlash' => false])->name('contactCheck');
SimpleRouter::get('/conditions', [PageController::class, 'conditions'])->setSettings(['includeSlash' => false])->name('conditions');
SimpleRouter::get('/legal', [PageController::class, 'legal'])->setSettings(['includeSlash' => false])->name('legal');
SimpleRouter::get('/privacy', [PageController::class, 'privacy'])->setSettings(['includeSlash' => false])->name('privacy');
SimpleRouter::get('/refund', [PageController::class, 'refund'])->setSettings(['includeSlash' => false])->name('refund');

// Routes cart
SimpleRouter::match(['get', 'post'], '/cart', [CartController::class, 'cart'])->setSettings(['includeSlash' => false])->name('cart');
SimpleRouter::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
SimpleRouter::post('/update-quantity', [CartController::class, 'updateQuantity'])->name('updateQuantity');
SimpleRouter::post('/delete-from-cart', [CartController::class, 'deleteFromCart'])->name('deleteFromCart');
SimpleRouter::get('/success', [CartController::class, 'success'])->name('success');
SimpleRouter::post('/update-shipping-costs', [CartController::class, 'updateShippingCosts'])->name('updateShippingCosts');
SimpleRouter::get('/stripe/checkout', [CartController::class, 'updateShippingCosts'])->name('updateShippingCosts');

// Routes comments
SimpleRouter::get('/new-comment/{slug}', [AccountController::class, 'newComment'])->setSettings(['includeSlash' => false])->name('newComment');
SimpleRouter::post('/check-comment/{slug}', [AccountController::class, 'checkComment'])->setSettings(['includeSlash' => false])->name('checkComment');


// Error handling for 404 and 403 errors
SimpleRouter::error(function (Request $request, \Exception $exception) {
    if ($exception instanceof NotFoundHttpException) {
        $controller = new DefaultController();
        $controller->notFound();
        exit;
    } elseif ($exception instanceof HttpException && $exception->getCode() === 403) {
        $controller = new DefaultController();
        $controller->forbidden();
        exit;
    } else {
        echo 'Une erreur inattendue s\'est produite';
    }
});
