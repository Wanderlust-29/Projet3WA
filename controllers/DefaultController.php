<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $am = new ArticleManager();
        
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $articles = $am->TopFour();

        $this->render("home/home.html.twig", [
            "articles"=>$articles,
            'session' => $session
        ]);
    }
}