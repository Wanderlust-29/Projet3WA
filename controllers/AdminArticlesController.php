<?php

class AdminArticlesController extends AbstractController
{

    // Tous les articles
    function articles()
    {
        $am = new ArticleManager();
        $articles = $am->findAll();
        $this->render("admin/admin-articles.html.twig", [
            'articles' => $articles,
        ]);
    }

    // Un seul article
    function article(int $id)
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

    //Page de création d'un article
    function newArticle()
    {
        $cm = new CategoryManager();
        $categories = $cm->findAll();

        $this->render("admin/admin-new-article.html.twig", [
            'categories' => $categories,
        ]);
    }

    // Mise à jour article
    function updateArticle()
    {
        $id = (int) $_POST['id'];

        if (isset($_POST)) {
            $am = new ArticleManager();

            $mm = new MediaManager();
            $media = $mm->findOne(intval($_POST["image_id"]));

            $cm = new CategoryManager();
            $category = $cm->findOne($_POST["category_id"]);

            $article = new Article($_POST["name"], $_POST["price"], $_POST["stock"], $category, $media, $_POST["description"], $_POST["ingredients"], $_POST["age"], $_POST["short_description"], $_POST["slug"]);
            $article->setId($_POST["id"]);

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

    public function updateArticleStock(int $id): void
    {

        // Vérifie si les données nécessaires sont présentes dans la requête POST
        if (isset($_POST["stock"])) {
            // Récupération des données du formulaire et nettoyage des entrées
            $newStock = (int) $_POST["stock"];

            // Initialise un gestionnaire d'articles et récupère l'article à partir de son identifiant
            $am = new ArticleManager();
            $article = $am->findOne($id);

            // Vérifie si l'article existe
            if ($article !== null) {
                // Met à jour le stock de l'article avec la nouvelle valeur
                $article->setStock($newStock);

                // Met à jour l'article dans la base de données
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

    public function updateArticleImage(): void
    {
        if (isset($_POST["article_id"]) && isset($_POST["image_id"]) && isset($_FILES['image']) && isset($_POST["alt"])) {
            $article_id = (int) $_POST["article_id"];
            $image_id = (int) $_POST["image_id"];
            $alt = $_POST["alt"];
            try {
                // Chemin temporaire de l'image uploadée
                $imageTmpPath = $_FILES["image"]["tmp_name"];
                // Répertoire de téléchargement des images
                $uploadDirectory = 'assets/media/';
                // Chemin de téléchargement de l'image avec son nom de fichier
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
                // Enregistrement de l'image dans la base de données
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

    public function addArticle(): void
    {
        if (
            isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["stock"])
            && isset($_POST["category"]) && isset($_FILES['image']) && isset($_POST["alt"])
            && isset($_POST["description"]) && isset($_POST["ingredients"]) && isset($_POST["age"])
            && isset($_POST["short_description"])
        ) {
            try {
                // Chemin temporaire de l'image uploadée
                $imageTmpPath = $_FILES["image"]["tmp_name"];
                // Répertoire de téléchargement des images
                $uploadDirectory = 'assets/media/';
                // Chemin de téléchargement de l'image avec son nom de fichier
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
                // Récupération des données du formulaire et nettoyage des entrées
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

                // Récupération de la catégorie sélectionnée
                $cm = new CategoryManager();
                $category = $cm->findOne($categoryId);

                // Enregistrement de l'image dans la base de données
                $mm = new MediaManager();
                $media = new Media($uploadPath, $alt);
                $mm->insert($media);

                // Création d'un nouvel article avec les données fournies
                $article = new Article($name, $price, $stock, $category, $media, $description, $ingredients, $age, $short_description, $slug);

                // Enregistrement de l'article dans la base de données
                $am = new ArticleManager();
                $insert = $am->insert($article);

                var_dump($insert);

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

    public function deleteArticle()
    {
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;

        $am = new ArticleManager();
        $articles = $am->findAll();

        $this->render("admin/admin-delete-article.html.twig", [
            'error' => $error,
            'articles' => $articles,
        ]);
    }
}
