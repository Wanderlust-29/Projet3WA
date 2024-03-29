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
        $cmc = new CommentController();

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
                $atc->articles();
            }         
            else if($get["route"] === "article")
            {
                $atc->article($get["id"]);
            }
            else if($get["route"] === "dog-food")
            {
                $atc->dogFood();
            }
            else if($get["route"] === "treats")
            {
                $atc->treats();
            }
            else if($get["route"] === "toys")
            {
                $atc->toys();
            }
            else if($get["route"] === "contact")
            {
                $dc->contact();
            }
            else if($get["route"] === "conditions")
            {
                $ic->conditions();
            }
            else if($get["route"] === "legal")
            {
                $ic->legal();
            }
            else if($get["route"] === "privacy")
            {
                $ic->privacy();
            }
            else if($get["route"] === "refund")
            {
                $ic->refund();
            }
            else if($get["route"] === "cart")
            {
                $cc->cart();
            }
            else if($get["route"] === "add-to-cart")
            {
                $cc->addToCart();
            }
            else if($get["route"] === "deleteFromCart")
            {
                $cc->deleteFromCart();
            }
            else if($get["route"] === "success")
            {
                $cc->success();
            }
            else if($get["route"] === "comment")
            {
                $cmc->newComment($get["articleId"]);
            }
            else if($get["route"] === "check-comment")
            {
                $cmc->checkComment($get["articleId"]);
            }
            else if($get["route"] === "articles-search")
            {
                $atc->search();
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