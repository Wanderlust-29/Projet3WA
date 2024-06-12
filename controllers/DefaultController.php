<?php

class DefaultController extends AbstractController
{
    /**
     * Renders the home page.
     * Retrieves top 9 articles and calculates total price of items in the cart.
     */
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

    /**
     * Renders the 404 Not Found page.
     */
    public function notfound(): void
    {
        $this->render("default/404.html.twig", []);
    }

    /**
     * Renders the 403 Forbidden page.
     */
    public function forbidden(): void
    {
        $this->render("default/403.html.twig", []);
    }
}
