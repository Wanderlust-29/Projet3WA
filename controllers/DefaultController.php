<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $am = new ArticleManager();

        $articles = $am->TopFour();
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $this->render("pages/home.html.twig", [
            "articles"=>$articles,
            "session"=>$session
        ]);
    }

    public function contact() : void
    {
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $this->render("pages/contact.html.twig", [
            "session"=>$session
        ]);
    }
}