<?php

class PageController extends AbstractController
{

    // Récupère tous les articles
    public function articles(): void
    {
        $am = new ArticleManager();

        $articles = $am->findAll();

        $this->render("pages/articles.html.twig", [
            "articles" => $articles,
        ]);
    }

    public function sort()
    {
        $am = new ArticleManager();
        $articles = [];

        if ($_POST['order-by'] === "popularity") {
            $articles = $am->sortByPopularity();
        } elseif ($_POST['order-by'] === "price_desc") {
            $articles = $am->sortByDesc();
        } elseif ($_POST['order-by'] === "price_asc") {
            $articles = $am->sortByAsc();
        } else {
            $this->redirect("/articles");
        }

        $this->render("pages/sort-result-articles.html.twig", [
            "articles" => $articles,
        ]);
    }

    public function sortByCategory()
    {
        if ($_POST["slug"]) {
            $slug = $_POST["slug"];
            // Récupération de l'ID de la catégorie
            $cm = new CategoryManager();
            $categoryId = $cm->findOneBySlug($slug);

            $am = new ArticleManager();
            $articles = [];

            if ($_POST['order-by'] === "popularity") {
                $articles = $am->sortByPopularityCat($categoryId);
            } elseif ($_POST['order-by'] === "price_desc") {
                $articles = $am->sortByDescCat($categoryId);
            } elseif ($_POST['order-by'] === "price_asc") {
                $articles = $am->sortByAscCat($categoryId);
            } else {
                $this->redirect("/categorie/$slug/");
            }

            $this->render("pages/sort-result-category.html.twig", [
                "articles" => $articles,
                "slug" => $_POST["slug"],
                "category" => $categoryId
            ]);
        }
    }


    // Récupère un article
    public function article(string $slug): void
    {
        $success = isset($_SESSION["success-message"]) ? $_SESSION["success-message"] : null;
        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : null;

        unset($_SESSION["success-message"]);

        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        unset($_SESSION["error-message"]);



        $am = new ArticleManager();
        $cm = new CommentManager();

        $article = $am->findBySlug($slug);
        $comments = $cm->findAllById($article->getId());

        $soldOut = false;
        $stock = $article->getStock();

        if (!is_null($cart)) {
            foreach ($cart as $cartItem) {
                // Vérifier si l'article du panier correspond à l'article actuel
                if ($cartItem['id'] === $article->getId()) {
                    if ($stock <= $cartItem["quantity"]) {
                        $soldOut = true;
                        break;
                    }
                }
            }
        }



        // Calculer la moyenne des notes
        $totalGrade = 0;
        $numberOfComments = count($comments);
        foreach ($comments as $comment) {
            $totalGrade += $comment->getGrade();
        }

        $averageGrade = $numberOfComments > 0 ? $totalGrade / $numberOfComments : 0;
        $averageGrade = ceil($averageGrade);


        $this->render("pages/article.html.twig", [
            "article" => $article,
            "comments" => $comments,
            "success" => $success,
            "error" => $error,
            "averageGrade" => $averageGrade,
            'soldOut' => $soldOut,
        ]);
    }

    // Récupération des articles de la catégorie
    public function category(string $slug): void
    {
        // Récupéation des informations de la catégorie
        $cm = new CategoryManager();
        $category = $cm->findOneBySlug($slug);

        $category_id = $category->getId();

        // Récupération des articles
        $am = new ArticleManager();
        $articles = $am->findByCat($category_id);

        $this->render("pages/category.html.twig", [
            "category" => $category,
            "articles" => $articles,
        ]);
    }


    // Récupération des articles suivant le résultat de la recherche
    public function search(): void
    {
        if (isset($_POST['search'])) {
            // Vérifie si le jeton CSRF est valide
            $tokenManager = new CSRFTokenManager();
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $search = htmlspecialchars($_POST['search']);

                $am = new ArticleManager();
                $articles = $am->searchArticles($search);

                $this->render("pages/articles-search.html.twig", [
                    "articles" => $articles
                ]);
            } else {
                $_SESSION["error-message"] = "Token CSRF invalide";
                $this->redirect("/");
            }
        } else {
            $this->redirect("/");
        }
    }


    public function adopt(): void
    {
        $this->render("pages/adopt.html.twig", []);
    }

    public function contact(): void
    {
        $this->render("pages/contact.html.twig", [
            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }
    public function contactCheck()
    { {
            if (
                isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"])
                && isset($_POST["message"])
            ) {
                // Vérifie si le jeton CSRF est valide
                $tokenManager = new CSRFTokenManager();
                if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                    $cmm = new ContactMessagesManager();
                    // Crée un nouvel utilisateur et le sauvegarde en base de données
                    $firstName = htmlspecialchars($_POST["firstName"]);
                    $lastName = htmlspecialchars($_POST["lastName"]);
                    $email = htmlspecialchars($_POST["email"]);
                    $message = htmlspecialchars($_POST["message"]);
                    // $texte_echappe = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

                    $contactMessage = new ContactMessages($firstName, $lastName, $email, $message);

                    if ($cmm->create($contactMessage)) {
                        // Redirige vers la page d'accueil si le message est bien enregistré
                        $this->redirect("/contact");
                    } else {
                        $this->redirect("/contact");
                    }
                } else {
                    $_SESSION["error-message"] = "Token CSRF invalide";
                    $this->redirect("/");
                }
            } else {
                $_SESSION["error-message"] = "Champs manquants";
                $this->redirect("/contact");
            }
        }
    }

    public function conditions(): void
    {
        $this->render("pages/conditions.html.twig", []);
    }
    public function legal(): void
    {
        $this->render("pages/legal.html.twig", []);
    }
    public function privacy(): void
    {
        $this->render("pages/privacy.html.twig", []);
    }
    public function refund(): void
    {
        $this->render("pages/refund.html.twig", []);
    }
}
