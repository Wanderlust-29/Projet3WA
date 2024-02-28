<?php

class Router
{
    public function handleRequest(array $get) : void
    {
        $dc = new DefaultController();
        $pc = new ProductController();

        if(!isset($get["route"]))
        {
            $dc->home();
        }
        else if(isset($get["route"]) && $get["route"] === "product")
        {
            $pc->product();
        }
    }
}