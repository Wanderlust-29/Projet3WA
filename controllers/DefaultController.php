<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $nm = new UserManager();
        $mm = new MediaManager();
        $am = new ArticleManager();
        $cm = new CategoryManager();
        $om = new OrderManager();
        $oam = new OrderArticleManager();

        $users = $nm->findAll();
        $medias = $mm->findAll();
        $articles = $am->findAll();
        $categories = $cm->findAll();
        $orders = $om->findAll();
        $ordersArticles = $oam->findAll();

        dump($users);
        dump($medias);
        dump($articles);
        dump($categories);
        dump($orders);
        dump($ordersArticles);

        $this->render("home.html.twig", [
            "users"=>$users,
            "medias"=>$medias
        ]);
    }
}