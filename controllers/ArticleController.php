<?php

class ArticleController extends AbstractController
{
    public function articles() : void
    {   
        $am = new ArticleManager();
        
        $articles = $am->findAll();
        
        $this->render("pages/articles.html.twig", [
            "articles"=>$articles
        ]);
    }
    public function article(string $id) : void
    {
        $am = new ArticleManager();

        $article = $am->findOne(intval($id));

        $this->render("pages/article.html.twig", [
            "article"=>$article
        ]);
    }
    public function dogFood() : void
    {
        $am = new ArticleManager();
        $this->render("pages/dog-food.html.twig", [
        ]);
    }
    public function toys() : void
    {
        $am = new ArticleManager();
        $this->render("pages/toys.html.twig", [
        ]);
    }
    public function treats() : void
    {   
        
        $am = new ArticleManager();
        $this->render("pages/toys.html.twig", [
        ]);
    }
}