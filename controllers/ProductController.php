<?php

class ProductController extends AbstractController
{
    public function product() : void
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

        $this->render("product.html.twig", [
            "articles"=>$articles
        ]);
    }
}