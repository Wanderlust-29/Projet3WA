<?php

use \Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/login-admin', [AuthController::class, 'loginAdmin'])->name('loginAdmin');
SimpleRouter::post('/check-admin', [AuthController::class, 'checkAdmin'])->name('checkAdmin');

SimpleRouter::group(['middleware' => Projet3wa\Middlewares\AuthAdmin::class, 'prefix' => '/admin'], function () {
    // Home
    SimpleRouter::get('/', [AdminController::class, 'admin'])->name('admin');
    // Routes orders
    SimpleRouter::get('/orders', [AdminOrdersController::class, 'orders'])->name('orders');
    SimpleRouter::get('/orders/{id}', [AdminOrdersController::class, 'order'])->name('order');
    SimpleRouter::post('/orders/update/status', [AdminOrdersController::class, 'updateStatus'])->name('updateStatus');
    // Routes users
    SimpleRouter::post('/users/add', [AdminUsersController::class, 'addUser'])->name('addUser');
    SimpleRouter::post('/users/delete', [AdminUsersController::class, 'deleteUser'])->name('deleteUser');
    SimpleRouter::post('/users/update', [AdminUsersController::class, 'updateUser'])->name('updateUser');
    SimpleRouter::get('/users/new', [AdminUsersController::class, 'newUser'])->name('newUser');
    SimpleRouter::get('/users', [AdminUsersController::class, 'users'])->name('users');
    SimpleRouter::get('/users/{id}', [AdminUsersController::class, 'user'])->name('user');
    // Routes articles
    SimpleRouter::post('/articles/add', [AdminArticlesController::class, 'addArticle'])->name('addArticle');
    SimpleRouter::post('/articles/delete', [AdminArticlesController::class, 'deleteArticle'])->name('deleteArticle');
    SimpleRouter::post('/articles/update/', [AdminArticlesController::class, 'updateArticle'])->name('updateArticle');
    SimpleRouter::post('/articles/update/image', [AdminArticlesController::class, 'updateArticleImage'])->name('updateArticleImage');
    SimpleRouter::post('/articles/update/stock/{id}', [AdminArticlesController::class, 'updateArticleStock'])->name('updateArticleStock');
    SimpleRouter::get('/articles/new', [AdminArticlesController::class, 'newArticle'])->name('newArticle');
    SimpleRouter::get('/articles', [AdminArticlesController::class, 'articles'])->name('articles');
    SimpleRouter::get('/articles/{id}', [AdminArticlesController::class, 'article'])->name('article');
    // Routes categories
    SimpleRouter::post('/categories/add', [AdminCategoriesController::class, 'addCategory'])->name('addCategory');
    SimpleRouter::post('/categories/update', [AdminCategoriesController::class, 'updateCategory'])->name('updateCategory');
    SimpleRouter::get('/categories', [AdminCategoriesController::class, 'categories'])->name('categories');
    SimpleRouter::get('/categories/new', [AdminCategoriesController::class, 'newCategory'])->name('newCategory');
    SimpleRouter::get('/categories/{id}', [AdminCategoriesController::class, 'category'])->name('category');
    // Routes shippings
    SimpleRouter::post('/shippings/add', [AdminShippingsController::class, 'addShipping'])->name('addShipping');
    SimpleRouter::post('/shippings/delete', [AdminShippingsController::class, 'deleteShipping'])->name('deleteShipping');
    SimpleRouter::post('/shippings/update', [AdminShippingsController::class, 'updateShipping'])->name('updateShipping');
    SimpleRouter::get('/shippings', [AdminShippingsController::class, 'shippings'])->name('shippings');
    SimpleRouter::get('/shippings/new', [AdminShippingsController::class, 'newShipping'])->name('newShipping');
    SimpleRouter::get('/shippings/{id}', [AdminShippingsController::class, 'shipping'])->name('shipping');
    // Routes comments
    SimpleRouter::get('/comments', [AdminCommentsController::class, 'comments'])->name('comments');
    SimpleRouter::get('/comments/pending', [AdminCommentsController::class, 'pendingComments'])->name('pendingComments');
    SimpleRouter::post('/comments/delete', [AdminCommentsController::class, 'deleteComment'])->name('deleteComment');
    SimpleRouter::post('/comments/approve', [AdminCommentsController::class, 'approveComment'])->name('approveComment');
    // Routes messages
    SimpleRouter::get('/messages', [AdminMessagesController::class, 'messages'])->name('messages');
    SimpleRouter::post('/messages/delete', [AdminMessagesController::class, 'deleteMessage'])->name('deleteMessage');
});
