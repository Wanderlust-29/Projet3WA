<?php

class Router
{
    public function handleRequest(array $get) : void
    {
        $dc = new DefaultController();

        if(!isset($get["route"]))
        {
            $dc->home();
        }
    }
}