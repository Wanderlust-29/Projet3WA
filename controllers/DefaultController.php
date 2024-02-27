<?php

class DefaultController extends AbstractController
{
    public function home() : void
    {
        $nm = new UserManager();
        $mm = new MediaManager();

        $users = $nm->findAll();
        $medias = $mm->findAll();

        dump($users);
        dump($medias);

        $this->render("home.html.twig", [
            "users"=>$users,
            "medias"=>$medias
        ]);
    }
}