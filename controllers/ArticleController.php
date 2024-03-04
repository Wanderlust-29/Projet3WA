<?php

class ArticleController extends AbstractController
{
    public function articles() : void
    {
        $am = new ArticleManager();

        $articles = $am->findAll();
        
        $this->render("articles/articles.html.twig", [
            "articles"=>$articles
        ]);
    }
    public function article(string $id) : void
    {
        $am = new ArticleManager();

        $article = $am->findOne(intval($id));

        $this->render("articles/article.html.twig", [
            "article"=>$article
        ]);
    }
}