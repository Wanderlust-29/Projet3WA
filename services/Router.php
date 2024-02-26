<?php

class Router
{
    public function handleRequest($route)
    {
        if (empty($route)) {
            $pageController = new PageController();
            $pageController->home();
        }
    }
}