<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $am = new ArticleManager();
        $articles = $am->TopFour();

        $this->render("default/home.html.twig", [
            "articles"=>$articles,
        ]);
    }

    public function notfound() : void
    {
        $this->render("default/404.html.twig", [
        ]);
    }
}