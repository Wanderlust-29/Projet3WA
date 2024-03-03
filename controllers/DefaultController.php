<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $am = new ArticleManager();
        
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $articles = $am->TopFour();


        // dump($users);
        // dump($medias);
        // dump($articles);
        // dump($categories);
        // dump($orders);

        $this->render("home.html.twig", [
            "articles"=>$articles,
            'session' => $session
        ]);
    }
}