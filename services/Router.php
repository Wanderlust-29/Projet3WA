<?php

class Router
{
    public function handleRequest(array $get) : void
    {
        $dc = new DefaultController();
        $athc = new AuthController();
        $acc = new AccountController();
        $atc = new ArticleController();
        $ic = new InfosController();
        $cc = new CartController();

        if(!isset($get["route"]))
        {
            $dc->home();
        }
        else if(isset($get["route"]) && $get["route"] === "login")
        {
            $athc->login();
        }
        else if(isset($get["route"]) && $get["route"] === "check-login")
        {
            $athc->checkLogin();
        }
        else if(isset($get["route"]) && $get["route"] === "register")
        {
            $athc->register();
        }
        else if(isset($get["route"]) && $get["route"] === "check-register")
        {
            $athc->checkRegister();
        }
        else if(isset($get["route"]) && $get["route"] === "logout")
        {
            $athc->logout();
        }
        else if(isset($get["route"]) && $get["route"] === "login-admin")
        {
            $athc->admin();
        }
        else if(isset($get["route"]) && $get["route"] === "check-admin")
        {
            $athc->checkAdmin();
        }
        else if(isset($get["route"]) && $get["route"] === "account")
        {
            $acc->account();
        }
        else if(isset($get["route"]) && $get["route"] === "admin")
        {
            $acc->admin();
        }
        else if(isset($get["route"]) && $get["route"] === "update")
        {
            $acc->updateUserProfile();
        }
        else if(isset($get["route"]) && $get["route"] === "update-stock")
        {
            $acc->updateStock();
        }
        else if(isset($get["route"]) && $get["route"] === "add-article")
        {
            $acc->createArticle();
        }
        else if(isset($get["route"])  && $get["route"] === "delete")
        {
            $acc->deleteUser();
        }
        else if(isset($get["route"]) && $get["route"] === "articles")
        {
            $atc->articles();
        }         
        else if(isset($get["route"]) && isset($get["id"]) && $get["route"] === "article")
        {
            $atc->article($get["id"]);
        }
        else if(isset($get["route"]) && $get["route"] === "dog-food")
        {
            $atc->dogFood();
        }
        else if(isset($get["route"])  && $get["route"] === "treats")
        {
            $atc->treats();
        }
        else if(isset($get["route"]) && $get["route"] === "toys")
        {
            $atc->toys();
        }
        else if(isset($get["route"]) && $get["route"] === "contact")
        {
            $dc->contact();
        }
        else if(isset($get["route"]) && $get["route"] === "conditions")
        {
            $ic->conditions();
        }
        else if(isset($get["route"]) && $get["route"] === "legal")
        {
            $ic->legal();
        }
        else if(isset($get["route"]) && $get["route"] === "privacy")
        {
            $ic->privacy();
        }
        else if(isset($get["route"]) && $get["route"] === "refund")
        {
            $ic->refund();
        }
        else if(isset($get["route"]) && $get["route"] === "cart")
        {
            $cc->showCart();
        }
        else if(isset($get["route"]) && isset($get["id"]) && $get["route"] === "add-to-cart")
        {
            $cc->addToCart($get["id"]);
        }
        else if(isset($get["route"]) && $get["route"] === "deleteFromCart")
        {
            $cc->deleteFromCart();
        }
        else
        {
            $dc->home();
        }
    }
}