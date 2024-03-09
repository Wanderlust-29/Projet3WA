<?php

class ArticleController extends AbstractController
{
    public function articles() : void
    {   
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
        $am = new ArticleManager();
        
        $articles = $am->findAll();
        
        $this->render("pages/articles.html.twig", [
            "articles"=>$articles,
            "session"=>$session,
            "error"=>$error
        ]);
    }
    public function article(string $id) : void
    {
        $am = new ArticleManager();
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $article = $am->findOne(intval($id));

        $this->render("pages/article.html.twig", [
            "article"=>$article,
            "session"=>$session,
            "error"=>$error
        ]);
    }
    public function dogFood() : void
    {
        $am = new ArticleManager();
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $articles = $am->findAll();

        $this->render("pages/dog-food.html.twig", [
            "articles"=>$articles,
            "session"=>$session,
            "error"=>$error
        ]);
    }
    public function toys() : void
    {
        $am = new ArticleManager();
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $articles = $am->findAll();

        $this->render("pages/toys.html.twig", [
            "articles"=>$articles,
            "session"=>$session,
            "error"=>$error
        ]);
    }
    public function treats() : void
    {   
        $am = new ArticleManager();
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $articles = $am->findAll();

        $this->render("pages/treats.html.twig", [
            "articles"=>$articles,
            "session"=>$session,
            "error"=>$error
        ]);
    }
}