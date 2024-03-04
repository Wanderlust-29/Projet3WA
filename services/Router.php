<?php

class Router
{
    public function handleRequest(array $get) : void
    {
        $dc = new DefaultController();
        $athc = new AuthController();
        $acc = new AccountController();
        $atc = new ArticleController();

        if(!isset($get["route"]))
        {
            $dc->home();
        }
        else if(isset($get["route"]) && $get["route"] === "articles")
        {
            $atc->articles();
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
        else if(isset($get["route"]) && $get["route"] === "account")
        {
            $acc->account();
        }
        else if(isset($get["route"]) && $get["route"] === "update")
        {
            $acc->updateUserProfile();
        }         
        else if(isset($get["route"]) && isset($get["id"]) && $get["route"] === "articles")
        {
            $atc->article($get["id"]);
        }
        else
        {
            $dc->home();
        }
    }
}