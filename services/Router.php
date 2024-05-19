<?php

class Router
{
    public function handleRequest(array $get) : void
    {
        $dc = new DefaultController();
        $athc = new AuthController();
        $acc = new AccountController();
        $pc = new PageController();
        $cc = new CartController();
        

        if(isset($get["route"]))
        {
            if($get["route"] === "login")
            {
                $athc->login();
            }
            else if($get["route"] === "check-login")
            {
                $athc->checkLogin();
            }
            else if($get["route"] === "register")
            {
                $athc->register();
            }
            else if($get["route"] === "check-register")
            {
                $athc->checkRegister();
            }
            else if($get["route"] === "logout")
            {
                $athc->logout();
            }
            else if($get["route"] === "login-admin")
            {
                $athc->admin();
            }
            else if($get["route"] === "check-admin")
            {
                $athc->checkAdmin();
            }
            else if($get["route"] === "account")
            {
                $acc->account();
            }
            else if($get["route"] === "admin")
            {
                $acc->admin();
            }
            else if($get["route"] === "admin-orders")
            {
                $acc->adminOrders();
            }
            else if($get["route"] === "admin-users")
            {
                $acc->adminUsers();
            }
            else if($get["route"] === "admin-stocks")
            {
                $acc->adminStocks();
            }
            else if($get["route"] === "admin-add-article")
            {
                $acc->adminAddArticle();
            }
            else if($get["route"] === "update")
            {
                $acc->updateUserProfile();
            }
            else if($get["route"] === "update-stock")
            {
                $acc->updateStock();
            }
            else if($get["route"] === "add-article")
            {
                $acc->createArticle();
            }
            else if($get["route"] === "delete")
            {
                $acc->deleteUser();
            }
            else if($get["route"] === "articles")
            {
                $pc->articles();
            }         
            else if($get["route"] === "article")
            {
                $pc->article($get["id"]);
            }
            else if($get["route"] === "dog-food")
            {
                $pc->dogFood();
            }
            else if($get["route"] === "treats")
            {
                $pc->treats();
            }
            else if($get["route"] === "toys")
            {
                $pc->toys();
            }
            else if($get["route"] === "contact")
            {
                $pc->contact();
            }
            else if($get["route"] === "conditions")
            {
                $pc->conditions();
            }
            else if($get["route"] === "legal")
            {
                $pc->legal();
            }
            else if($get["route"] === "privacy")
            {
                $pc->privacy();
            }
            else if($get["route"] === "refund")
            {
                $pc->refund();
            }
            else if($get["route"] === "cart")
            {
                $cc->cart();
            }
            else if($get["route"] === "add-to-cart")
            {
                $cc->addToCart();
            }
            else if($get["route"] === "delete-from-cart")
            {
                $cc->deleteFromCart();
            }
            else if($get["route"] === "success")
            {
                $cc->success();
            }
            else if($get["route"] === "comment")
            {
                $acc->newComment($get["articleId"]);
            }
            else if($get["route"] === "check-comment")
            {
                $acc->checkComment($get["articleId"]);
            }
            else if($get["route"] === "articles-search")
            {
                $pc->search();
            }
            else if($get["route"] === "update-shipping-costs")
            {
                $cc->updateShippingCosts();
            }
            else
            {
                $dc->notFound();
            }
        }
        else
        {
            $dc->home();
        }
    }
}