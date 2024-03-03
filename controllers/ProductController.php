<?php

class ProductController extends AbstractController
{
    public function product() : void
    {
        $am = new ArticleManager();

        $articles = $am->findAll();
        // dump($articles);
        
        $this->render("product.html.twig", [
            "articles"=>$articles
        ]);
    }
}