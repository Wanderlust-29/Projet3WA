<?php

class CartController extends AbstractController
{


    public function cart() : void
    {
        $am = new ArticleManager();
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $articles = $am->findAll();
        $this->render("pages/cart.html.twig", [
            "articles"=>$articles,
            "session"=>$session,
            "error"=>$error
        ]);
    }
}