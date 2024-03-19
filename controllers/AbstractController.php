<?php

abstract class AbstractController
{
    private \Twig\Environment $twig;
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader,[
            'debug' => true,
        ]);
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        // Nombre d'articles dans le panier
        $cm = new CartManager();
        $cart = $cm->getCart();
        $items = $cart->getItems();
        $count = count($items);

        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal("session", $session);
        $twig->addGlobal("count", $count);

        $this->twig = $twig;
    }

    protected function render(string $template, array $data) : void
    {
        echo $this->twig->render($template, $data);
    }
    protected function redirect(string $route) : void
    {
        header("Location: $route");
    }
}