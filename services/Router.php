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
        

        if(isset($get["route"]) && !empty($get["route"])){
            $route = $get["route"];
            if($route === "login")
            {
                $athc->login();
            }
            else if($route === "check-login")
            {
                $athc->checkLogin();
            }
            else if($route === "register")
            {
                $athc->register();
            }
            else if($route === "check-register")
            {
                $athc->checkRegister();
            }
            else if($route === "logout")
            {
                $athc->logout();
            }
            else if($route === "login-admin")
            {
                $athc->admin();
            }
            else if($route === "check-admin")
            {
                $athc->checkAdmin();
            }
            else if($route === "account")
            {
                $acc->account();
            }
            else if($route === "admin")
            {
                $acc->admin();
            }
            else if($route === "admin-orders")
            {
                $acc->adminOrders();
            }
            else if($route === "admin-users")
            {
                $acc->adminUsers();
            }
            else if($route === "admin-stocks")
            {
                $acc->adminStocks();
            }
            else if($route === "admin-add-article")
            {
                $acc->adminAddArticle();
            }
            else if($route === "update")
            {
                $acc->updateUserProfile();
            }
            else if($route === "update-stock")
            {
                $acc->updateStock();
            }
            else if($route === "add-article")
            {
                $acc->createArticle();
            }
            else if($route === "delete")
            {
                $acc->deleteUser();
            }
            else if($route === "articles")
            {
                $pc->articles();
            }         
            else if($route === "article")
            {
                $pc->article($get["id"]);
            }
            else if($route === "categorie")
            {   
                $slug = isset($get["slug"]) && !empty($get["slug"]) ? $get["slug"] : null;
                if(!is_null($slug)){
                    $pc->categorie($slug);
                }else{
                    $dc->notFound();
                }
            }
            // else if($route === "treats")
            // {
            //     $pc->treats();
            // }
            // else if($route === "toys")
            // {
            //     $pc->toys();
            // }
            else if($route === "contact")
            {
                $pc->contact();
            }
            else if($route === "conditions")
            {
                $pc->conditions();
            }
            else if($route === "legal")
            {
                $pc->legal();
            }
            else if($route === "privacy")
            {
                $pc->privacy();
            }
            else if($route === "refund")
            {
                $pc->refund();
            }
            else if($route === "cart")
            {
                $cc->cart();
            }
            else if($route === "add-to-cart")
            {
                $cc->addToCart();
            }
            else if($route === "delete-from-cart")
            {
                $cc->deleteFromCart();
            }
            else if($route === "success")
            {
                $cc->success();
            }
            else if($route === "comment")
            {
                $acc->newComment($get["articleId"]);
            }
            else if($route === "check-comment")
            {
                $acc->checkComment($get["articleId"]);
            }
            else if($route === "articles-search")
            {
                $pc->search();
            }
            else if($route === "update-shipping-costs")
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