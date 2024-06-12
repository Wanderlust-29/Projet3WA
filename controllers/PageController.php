<?php

class PageController extends AbstractController
{
    /**
     * Retrieves all articles and renders the articles page.
     */
    public function articles(): void
    {
        $am = new ArticleManager();
        $articles = $am->findAll();

        $this->render("pages/articles.html.twig", [
            "articles" => $articles,
        ]);
    }

    /**
     * Sorts articles based on the selected criteria and renders the articles page.
     */
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

        $this->render("pages/articles.html.twig", [
            "articles" => $articles,
        ]);
    }

    /**
     * Sorts articles by category based on the selected criteria and renders the category page.
     */
    public function sortByCategory()
    {
        if ($_POST["slug"]) {
            $slug = $_POST["slug"];
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

            $this->render("pages/category.html.twig", [
                "articles" => $articles,
                "slug" => $_POST["slug"],
                "category" => $categoryId
            ]);
        }
    }

    /**
     * Retrieves an article by its slug, calculates average grade from comments,
     * checks stock availability against the cart, and renders the article page.
     */
    public function article(string $slug): void
    {
        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : null;

        $am = new ArticleManager();
        $cm = new CommentManager();

        $article = $am->findBySlug($slug);
        $comments = $cm->findAllById($article->getId());

        $soldOut = false;
        $stock = $article->getStock();

        if (!is_null($cart)) {
            foreach ($cart as $cartItem) {
                if ($cartItem['id'] === $article->getId()) {
                    if ($stock <= $cartItem["quantity"]) {
                        $soldOut = true;
                        break;
                    }
                }
            }
        }

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
            "averageGrade" => $averageGrade,
            'soldOut' => $soldOut,
        ]);
    }

    /**
     * Retrieves articles by category slug, and renders the category page.
     */
    public function category(string $slug): void
    {
        $cm = new CategoryManager();
        $category = $cm->findOneBySlug($slug);

        $category_id = $category->getId();

        $am = new ArticleManager();
        $articles = $am->findByCat($category_id);

        $this->render("pages/category.html.twig", [
            "category" => $category,
            "articles" => $articles,
        ]);
    }

    /**
     * Retrieves articles based on search query and renders the search results page.
     */
    public function search(): void
    {
        if (isset($_POST['search'])) {
            $tokenManager = new CSRFTokenManager();

            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $search = htmlspecialchars($_POST['search']);

                $am = new ArticleManager();
                $articles = $am->searchArticles($search);

                $this->render("pages/articles-search.html.twig", [
                    "articles" => $articles
                ]);
            } else {
                $this->redirect("/");
            }
        } else {
            $this->redirect("/");
        }
    }

    /**
     * Renders the adopt page.
     */
    public function adopt(): void
    {
        $this->render("pages/adopt.html.twig", []);
    }

    /**
     * Renders the contact page with CSRF token.
     */
    public function contact(): void
    {
        $this->render("pages/contact.html.twig", [
            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }

    /**
     * Processes the contact form submission, validates CSRF token,
     * creates a contact message, and notifies the user.
     */
    public function contactCheck()
    {
        if (
            isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"])
            && isset($_POST["message"])
        ) {
            $tokenManager = new CSRFTokenManager();
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $firstName = htmlspecialchars($_POST["firstName"]);
                $lastName = htmlspecialchars($_POST["lastName"]);
                $email = htmlspecialchars($_POST["email"]);
                $message = htmlspecialchars($_POST["message"]);

                $cmm = new ContactMessagesManager();
                $contactMessage = new ContactMessages($firstName, $lastName, $email, $message);

                $cmm->create($contactMessage);
                $type = 'success';
                $text = "Le message à bien été envoyé";
            } else {
                $type = 'error';
                $text = "Token CSRF invalide";
            }
        } else {
            $type = 'error';
            $text = "Champs manquants";
        }

        $this->notify($text, $type);
        $this->redirect("/contact");
    }

    /**
     * Renders the conditions page.
     */
    public function conditions(): void
    {
        $this->render("pages/conditions.html.twig", []);
    }

    /**
     * Renders the legal page.
     */
    public function legal(): void
    {
        $this->render("pages/legal.html.twig", []);
    }

    /**
     * Renders the privacy page.
     */
    public function privacy(): void
    {
        $this->render("pages/privacy.html.twig", []);
    }

    /**
     * Renders the refund page.
     */
    public function refund(): void
    {
        $this->render("pages/refund.html.twig", []);
    }
}
