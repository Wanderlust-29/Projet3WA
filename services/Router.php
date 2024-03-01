<?php

class Router
{
    public function handleRequest(array $get) : void
    {
        $dc = new DefaultController();
        $pc = new ProductController();
        $ac = new AuthController();
        $acc = new AccountController();

        if(!isset($get["route"]))
        {
            $dc->home();
        }
        else if(isset($get["route"]) && $get["route"] === "product")
        {
            $pc->product();
        }
        else if(isset($get["route"]) && $get["route"] === "login")
        {
            $ac->login();
        }
        else if(isset($get["route"]) && $get["route"] === "check-login")
        {
            $ac->checkLogin();
        }
        else if(isset($get["route"]) && $get["route"] === "register")
        {
            $ac->register();
        }
        else if(isset($get["route"]) && $get["route"] === "check-register")
        {
            $ac->checkRegister();
        }
        else if(isset($get["route"]) && $get["route"] === "logout")
        {
            $ac->logout();
        }
        else if(isset($get["route"]) && $get["route"] === "account")
        {
            $acc->account();
        }
        else
        {
            $dc->home();
        }
    }
}