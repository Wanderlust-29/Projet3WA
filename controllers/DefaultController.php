<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $am = new ArticleManager();

        $articles = $am->TopFour();

        $this->render("home/home.html.twig", [
            "articles"=>$articles,
        ]);
    }
}