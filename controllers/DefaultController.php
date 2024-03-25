<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $am = new ArticleManager();
        $articles = $am->TopFour();

        $this->render("pages/home.html.twig", [
            "articles"=>$articles,
        ]);
    }

    public function contact() : void
    {
        $this->render("pages/contact.html.twig", [
        ]);
    }

    public function notfound() : void
    {
        $this->render("pages/404.html.twig", [
        ]);
    }
}