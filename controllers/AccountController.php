<?php

class AccountController extends AbstractController
{
    public function account() : void
    {
        $um = new UserManager();
        $mm = new MediaManager();
        $am = new ArticleManager();
        $cm = new CategoryManager();
        $om = new OrderManager();
        $user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $users = $um->findAll();
        $medias = $mm->findAll();
        $articles = $am->findAll();
        $categories = $cm->findAll();
        $orders = $om->findAll();

        dump($users);
        dump($medias);
        dump($articles);
        dump($categories);
        dump($orders);

        $this->render("account.html.twig", [
            "medias"=>$medias,
            "articles"=>$articles,
            'user' => $user
        ]);
    }
}