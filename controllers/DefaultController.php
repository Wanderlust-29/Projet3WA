<?php

class DefaultController extends AbstractController
{
    public function home(): void
    {

        $am = new ArticleManager();
        $articles = $am->TopNine();

        $totalPrice = 0;
        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : null;

        if (!is_null($cart)) {
            foreach ($cart as $article) {
                if (isset($article['price'])) {
                    $totalPrice += $article['price'];
                }
            }
        }

        $this->render("default/home.html.twig", [
            "articles" => $articles,
            "cart" => $cart,
            "totalPrice" => $totalPrice,
        ]);
    }

    public function notfound(): void
    {
        $this->render("default/404.html.twig", []);
    }

    public function forbidden(): void
    {
        $this->render("default/403.html.twig", []);
    }
}
