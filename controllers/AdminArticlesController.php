<?php

class AdminArticlesController extends AbstractController
{
    /**
     * Renders the page displaying all articles.
     */
    function articles(): void
    {
        $am = new ArticleManager();
        $articles = $am->findAll();
        $this->render("admin/admin-articles.html.twig", [
            'articles' => $articles,
        ]);
    }

    /**
     * Renders the page displaying a single article based on ID.
     * Retrieves associated comments and categories.
     * @param int $id The ID of the article to display.
     */
    function article(int $id): void
    {
        $cm = new CommentManager();
        $comments = $cm->findAllById($id);

        $am = new ArticleManager();
        $article = $am->findOne($id);

        $cm = new CategoryManager();
        $categories = $cm->findAll();

        $this->render("admin/admin-article.html.twig", [
            'article' => $article,
            'categories' => $categories,
            'comments' => $comments
        ]);
    }

    /**
     * Renders the page for creating a new article.
     * Retrieves all categories for category selection.
     */
    function newArticle(): void
    {
        $cm = new CategoryManager();
        $categories = $cm->findAll();

        $this->render("admin/admin-new-article.html.twig", [
            'categories' => $categories,
        ]);
    }

    /**
     * Handles the update of an existing article in the database.
     * Retrieves article data from POST, including related media and categories.
     * Redirects to the updated article page upon success.
     */
    function updateArticle(): void
    {
        $id = (int) $_POST['id'];

        if (isset($_POST)) {
            $am = new ArticleManager();

            $mm = new MediaManager();
            $media = $mm->findOne(intval($_POST["image_id"]));

            $cm = new CategoryManager();
            $category = $cm->findOne($_POST["category_id"]);

            $article = new Article(
                $_POST["name"],
                $_POST["price"],
                $_POST["stock"],
                $category,
                $media,
                $_POST["description"],
                $_POST["ingredients"],
                $_POST["age"],
                $_POST["short_description"],
                $_POST["slug"]
            );
            $article->setId($id);

            $update = $am->update($article);

            if (!$update) {
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            } else {
                $type = 'success';
                $text = "La mise à jour a bien été effectuée 😃";
            }
        } else {
            $type = 'error';
            $text = "Veuillez choisir un statut différent de l'existant 🙄";
        }

        $this->notify($text, $type);
        $this->redirect(url('article', ['id' => $id]));
    }

    /**
     * Handles the update of an article's stock quantity.
     * Retrieves new stock quantity from POST and updates the article.
     * Redirects to the article page upon success.
     * @param int $id The ID of the article to update stock.
     */
    public function updateArticleStock(int $id): void
    {
        // Check if the necessary data is present in the POST request
        if (isset($_POST["stock"])) {
            // Retrieve form data and sanitize inputs
            $newStock = (int) $_POST["stock"];

            // Initialize an article manager and retrieve the article by its ID
            $am = new ArticleManager();
            $article = $am->findOne($id);

            // Check if the article exists
            if ($article !== null) {
                // Update the article's stock with the new value
                $article->setStock($newStock);

                // Update the article in the database
                $update = $am->updateStock($article);

                if (!$update) {
                    $type = 'error';
                    $text = "Un problème est survenu lors de la mise à jour du stock 😞";
                } else {
                    $type = 'success';
                    $text = "Le stock a bien été mis à jour 😃";
                }
            } else {
                $type = 'error';
                $text = "L'article n'existe pas 🤔";
            }
        } else {
            $type = 'error';
            $text = "Un problème est survenu lors de la mise à jour 😞";
        }
        $this->notify($text, $type);
        $this->redirect(url('article', ['id' => $id]));
    }

    /**
     * Handles the update of an article's image.
     * Retrieves article and image data from POST.
     * Uploads image file, updates article's image in database.
     * Redirects to the article page upon success.
     */
    public function updateArticleImage(): void
    {
        if (isset($_POST["article_id"]) && isset($_POST["image_id"]) && isset($_FILES['image']) && isset($_POST["alt"])) {
            $article_id = (int) $_POST["article_id"];
            $image_id = (int) $_POST["image_id"];
            $alt = $_POST["alt"];
            try {
                // Temporary path of the uploaded image
                $imageTmpPath = $_FILES["image"]["tmp_name"];
                // Image upload directory
                $uploadDirectory = 'assets/media/';
                // Upload path of the image with its filename
                $uploadPath = $uploadDirectory . basename($_FILES["image"]["name"]);
                move_uploaded_file($imageTmpPath, $uploadPath);
            } catch (Exception $e) {
                $url = url('article', ['id' => $article_id]);
                $type = 'error';
                $text = $e->getMessage();
                $this->notify($text, $type);
                $this->redirect($url);
            }

            try {
                // Save the image in the database
                $mm = new MediaManager();
                $media = new Media($uploadPath, $alt);
                $new_media = $mm->insert($media);

                $am = new ArticleManager();
                $article = $am->findOne($article_id);
                $update = $am->updateImage($article, $new_media);

                $url = url('article', ['id' => $article_id]);
                $type = 'success';
                $text = "L'image a bien été mises à jour 😃";
            } catch (Exception $e) {
                $url = url('article', ['id' => $article_id]);
                $type = 'error';
                $text = $e->getMessage();
                $this->notify($text, $type);
                $this->redirect($url);
            }
        } else {
            $url = url('articles');
            $type = 'error';
            $text = "Il manque des champs 😞";
        }
        $this->notify($text, $type);
        $this->redirect($url);
    }

    /**
     * Handles the insertion of a new article into the database.
     * Retrieves article data from POST, including related media and categories.
     * Redirects to the newly created article page upon success.
     */
    public function addArticle(): void
    {
        if (
            isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["stock"])
            && isset($_POST["category"]) && isset($_FILES['image']) && isset($_POST["alt"])
            && isset($_POST["description"]) && isset($_POST["ingredients"]) && isset($_POST["age"])
            && isset($_POST["short_description"])
        ) {
            try {
                // Temporary path of the uploaded image
                $imageTmpPath = $_FILES["image"]["tmp_name"];
                // Image upload directory
                $uploadDirectory = 'assets/media/';
                // Upload path of the image with its filename
                $uploadPath = $uploadDirectory . basename($_FILES["image"]["name"]);
                move_uploaded_file($imageTmpPath, $uploadPath);
            } catch (Exception $e) {
                $url = url('newArticle');
                $type = 'error';
                $text = $e->getMessage();
                $this->notify($text, $type);
                $this->redirect($url);
            }

            try {
                // Retrieve form data and sanitize inputs
                $name = htmlspecialchars($_POST["name"]);
                $price = htmlspecialchars($_POST["price"]);
                $stock = htmlspecialchars($_POST["stock"]);
                $categoryId = htmlspecialchars($_POST["category"]);
                $alt = htmlspecialchars($_POST["alt"]);
                $description = htmlspecialchars($_POST["description"]);
                $ingredients = htmlspecialchars($_POST["ingredients"]);
                $age = htmlspecialchars($_POST["age"]);
                $short_description = htmlspecialchars($_POST["short_description"]);
                $slug = $this->slugify($name);

                // Retrieve the selected category
                $cm = new CategoryManager();
                $category = $cm->findOne($categoryId);

                // Save the image in the database
                $mm = new MediaManager();
                $media = new Media($uploadPath, $alt);
                $mm->insert($media);

                // Create a new article with the provided data
                $article = new Article($name, $price, $stock, $category, $media, $description, $ingredients, $age, $short_description, $slug);

                // Save the article in the database
                $am = new ArticleManager();
                $insert = $am->insert($article);

                $url = url('article', ['id' => $insert]);
                $type = 'success';
                $text = "L'article " . $_POST["name"] . " a bien été créé 😃";
            } catch (Exception $e) {
                $url = url('newArticle');
                $type = 'error';
                $text = $e->getMessage();
                $this->notify($text, $type);
                $this->redirect($url);
            }
        } else {
            $url = url('newArticle');
            $type = 'error';
            $text = "Il manque des champs 😞";
        }
        $this->notify($text, $type);
        $this->redirect($url);
    }

    /**
     * Deletes an article based on the provided article ID.
     */
    public function deleteArticle(): void
    {
        $am = new ArticleManager();
        $articles = $am->findAll();

        $this->render("admin/admin-delete-article.html.twig", [
            'articles' => $articles,
        ]);
    }
}
