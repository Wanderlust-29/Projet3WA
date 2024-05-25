<?php

use Cocur\Slugify\Slugify;

abstract class AbstractController
{
    private \Twig\Environment $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader, [
            'debug' => true,
        ]);
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $slugify = new Slugify();

        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : null;
        $count = 0;
        if (!is_null($cart)) {
            foreach ($cart as $article) {
                if ($article['quantity']) {
                    $count += $article['quantity'];
                }
            }
        }

        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal("session", $session);
        $twig->addGlobal("count", $count);
        $twig->addGlobal("cart", $cart);
        $twig->addGlobal("slugify", $slugify);

        $this->twig = $twig;
    }

    protected function render(string $template, array $data): void
    {
        echo $this->twig->render($template, $data);
    }
    protected function redirect(string $route): void
    {
        header("Location: $route");
    }
    protected function renderJson(array $data): void
    {
        echo json_encode($data);
    }
}
