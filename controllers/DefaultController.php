<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $nm = new UserManager();
        $mm = new MediaManager();
        $am = new ArticleManager();
        $cm = new CategoryManager();

        $users = $nm->findAll();
        $medias = $mm->findAll();
        $articles = $am->findAll();
        $categories = $cm->findAll();

        dump($users);
        dump($medias);
        dump($articles);
        dump($categories);

        $this->render("home.html.twig", [
            "users"=>$users,
            "medias"=>$medias
        ]);
    }
}