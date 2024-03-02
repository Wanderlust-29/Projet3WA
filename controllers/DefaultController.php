<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $um = new UserManager();
        $mm = new MediaManager();
        $am = new ArticleManager();
        $cm = new CategoryManager();
        $om = new OrderManager();
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;


        $medias = $mm->findAll();
        $articles = $am->findAll();


        // dump($users);
        // dump($medias);
        // dump($articles);
        // dump($categories);
        // dump($orders);

        $this->render("home.html.twig", [
            "medias"=>$medias,
            "articles"=>$articles,
            'session' => $session
        ]);
    }
}