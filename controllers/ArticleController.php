<?php

class ArticleController extends AbstractController
{
    public function articles() : void
    {   
        $am = new ArticleManager();

        $articles = $am->findAll();
        
        $this->render("pages/articles.html.twig", [
            "articles"=>$articles,
        ]);
    }
    public function article(string $id) : void
    {
        $success = isset($_SESSION["success-message"]) ? $_SESSION["success-message"] : null;
        unset($_SESSION["success-message"]);
        
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        unset($_SESSION["error-message"]);

        $am = new ArticleManager();

        $article = $am->findOne(intval($id));

        $this->render("pages/article.html.twig", [
            "article"=>$article,
            "success" => $success,
            "error" => $error
        ]);
    }
    public function dogFood() : void
    {
        $am = new ArticleManager();

        $articles = $am->findAll();

        $this->render("pages/dog-food.html.twig", [
            "articles"=>$articles,
        ]);
    }
    public function toys() : void
    {
        $am = new ArticleManager();

        $articles = $am->findAll();

        $this->render("pages/toys.html.twig", [
            "articles"=>$articles,
        ]);
    }
    public function treats() : void
    {   
        $am = new ArticleManager();

        $articles = $am->findAll();

        $this->render("pages/treats.html.twig", [
            "articles"=>$articles,

        ]);
    }
}