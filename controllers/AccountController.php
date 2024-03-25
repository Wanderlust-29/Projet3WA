<?php

class AccountController extends AbstractController
{
    public function account(): void
    {
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
    
        $sessionId = null;
        $orders = [];
        $ordersArticles = [];
        
        // Vérifie si un utilisateur est connecté en session et s'il s'agit bien d'une instance de la classe User
        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId(); // Récupère l'identifiant de l'utilisateur connecté
            $om = new OrderManager(); // Initialise le gestionnaire de commandes
            $orders = $om->findByUserId($sessionId); // Récupère les commandes de l'utilisateur
    
            foreach ($orders as $order) {
                $orderId = $order->getId();
                $oAm = new OrderArticleManager();
                $orderArticles = $oAm->findByOrderId($orderId);
                $ordersArticles[$orderId] = $orderArticles;
            }
        }
    
        $this->render("account/account.html.twig", [
            'error' => $error,
            'orders' => $orders,
            'ordersArticles' => $ordersArticles,
        ]);
    }
    
    
    public function updateUserProfile(): void
    {
        if (isset($_SESSION['user'])) {
            $currentUser = $_SESSION['user'];
            
            // Vérifie si le mot de passe actuel est différent du nouveau mot de passe
            if (password_verify($_POST["password"], $currentUser->getPassword())) {
                $_SESSION["error-message"] = "Le mot de passe ne peut pas être le même que l'ancien";
            } else {
                // Vérifie si les nouveaux mots de passe correspondent
                if ($_POST["password"] === $_POST["confirm-password"]) {
                    // Vérifie la complexité du mot de passe
                    $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
        
                    if (preg_match($password_pattern, $_POST["password"])) {
                        // Met à jour les informations du profil utilisateur
                        $currentUser->setFirstName(htmlspecialchars($_POST["firstName"]));
                        $currentUser->setLastName(htmlspecialchars($_POST["lastName"]));
                        $currentUser->setEmail(htmlspecialchars($_POST["email"]));
                        $currentUser->setPassword(password_hash($_POST["password"], PASSWORD_BCRYPT));
                        $currentUser->setAddress(htmlspecialchars($_POST["address"]));
                        $currentUser->setCity(htmlspecialchars($_POST["city"]));
                        $currentUser->setPostalCode(htmlspecialchars($_POST["postalCode"]));
                        $currentUser->setCountry(htmlspecialchars($_POST["country"]));
            
                        // Initialise le gestionnaire d'utilisateurs et met à jour l'utilisateur dans la base de données
                        $um = new UserManager();
                        $um->update($currentUser);
            
                        // Met à jour la session utilisateur et réinitialise le message d'erreur
                        $_SESSION["user"] = $currentUser;
                        unset($_SESSION["error-message"]);
                        $this->redirect("index.php");
                    } elseif ($_POST["password"] !== null) {
                        $_SESSION["error-message"] = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                        $this->redirect("index.php?route=admin");
                    }
                } else { 
                    $_SESSION["error-message"] = "Les mots de passe ne correspondent pas";
                    $this->redirect("index.php?route=admin");
                }
            }
        } else {
            $_SESSION["error-message"] = "L'utilisateur n'est pas connecté.";
        }
        $this->redirect("index.php?route=account");
    }
    

    function admin(){
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
    
        $um = new UserManager();
        $am = new ArticleManager();
        $om = new OrderManager();
    
        $articles = $am->findAll();
        $users = $um->findAll();
        $orders = $om->findAllDecreasing();
    
        // Initialise un tableau pour stocker les articles de chaque commande
        $ordersArticles = [];

        // Pour chaque commande, récupère les articles associés
        foreach ($orders as $order) {
            $orderId = $order->getId();
            $oAm = new OrderArticleManager();
            $orderArticles = $oAm->findByOrderId($orderId);
            $ordersArticles[$orderId] = $orderArticles;
        }
    
        $this->render("account/admin.html.twig", [
            'error' => $error,
            'articles' => $articles,
            'users' => $users,
            'orders' => $orders,
            'ordersArticles' => $ordersArticles,
        ]);
    }


    public function deleteUser()
    {
        if (isset($_SESSION["user"]) && isset($_POST['delete']) && isset($_POST['userId'])) {
            $user = $_SESSION["user"];
            $userId = $_POST["userId"];
            if ($userId !== null) {
                $um = new UserManager();
                $um->delete($userId); // Supprimer l'utilisateur
                
                // Vérifier si l'utilisateur supprimé n'est pas l'administrateur actuellement connecté
                if ($user->getRole() !== "ADMIN") {
                    session_destroy(); // Détruire la session si l'utilisateur supprimé n'est pas un administrateur
                    $this->redirect("index.php");
                } else { // Gestion des erreurs
                    $this->redirect("index.php?route=admin");
                }
                unset($_SESSION["error-message"]);
                
            } else {
                $_SESSION["error-message"] = "Une erreur s'est produite lors de la suppression de l'utilisateur.";
                if($user->getRole() === "ADMIN"){
                    $this->redirect("index.php?route=admin");
                }else{
                    $this->redirect("index.php?route=account");
                }
            }
        } else {
            $_SESSION["error-message"] = "Une erreur s'est produite.";
            $this->redirect("index.php");
        }
    }
    

    public function updateStock(): void
    {
        if (isset($_SESSION['user'])) {
            // Vérifie si les données nécessaires sont présentes dans la requête POST
            if (isset($_POST["article_id"]) && isset($_POST["stock"])) {
                // Récupération des données du formulaire et nettoyage des entrées
                $articleId = $_POST["article_id"];
                $newStock = htmlspecialchars($_POST["stock"]);
    
                // Initialise un gestionnaire d'articles et récupère l'article à partir de son identifiant
                $am = new ArticleManager();
                $article = $am->findOne($articleId);
    
                // Vérifie si l'article existe
                if ($article !== null) {
                    // Met à jour le stock de l'article avec la nouvelle valeur
                    $article->setStock($newStock);
                    // Met à jour l'article dans la base de données
                    $am->update($article);
    
                    unset($_SESSION["error-message"]);
                    $this->redirect("index.php?route=admin");
                } else { // Gestion des erreurs
                    $_SESSION["error-message"] = "L'article n'existe pas.";
                    $this->redirect("index.php?route=admin");
                }
            } else {
                $_SESSION["error-message"] = "Veuillez définir le nouveau stock.";
                $this->redirect("index.php?route=admin");
            }
        } else {
            $_SESSION["error-message"] = "L'administrateur n'est pas connecté.";
            $this->redirect("index.php?route=login-admin");
        }
        $this->redirect("index.php?route=admin");
    }
    

    public function createArticle(): void
    {
        if (
            isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["stock"])
            && isset($_POST["category"]) && isset($_FILES['image']) && isset($_POST["alt"])
            && isset($_POST["description"]) && isset($_POST["ingredients"]) && isset($_POST["age"])
        ) {
            try {
                // Chemin temporaire de l'image uploadée
                $imageTmpPath = $_FILES["image"]["tmp_name"];
                // Répertoire de téléchargement des images
                $uploadDirectory = 'assets/media/';
                // Chemin de téléchargement de l'image avec son nom de fichier
                $uploadPath = $uploadDirectory . basename($_FILES["image"]["name"]);
    
                // Déplace le fichier téléchargé vers le répertoire de destination
                if (move_uploaded_file($imageTmpPath, $uploadPath)) {
                    // Récupération des données du formulaire et nettoyage des entrées
                    $name = htmlspecialchars($_POST["name"]);
                    $price = htmlspecialchars($_POST["price"]);
                    $stock = htmlspecialchars($_POST["stock"]);
                    $categoryId = htmlspecialchars($_POST["category"]);
                    $alt = htmlspecialchars($_POST["alt"]);
                    $description = htmlspecialchars($_POST["description"]);
                    $ingredients = htmlspecialchars($_POST["ingredients"]);
                    $age = htmlspecialchars($_POST["age"]);
    
                    // Récupération de la catégorie sélectionnée
                    $cm = new CategoryManager();
                    $category = $cm->findOne($categoryId);
    
                    // Enregistrement de l'image dans la base de données
                    $mm = new MediaManager();
                    $media = new Media($uploadPath, $alt);
                    $mm->insert($media);

                    // Création d'un nouvel article avec les données fournies
                    $article = new Article($name, $price, $stock, $category, $media, $description, $ingredients, $age);
    
                    // Enregistrement de l'article dans la base de données
                    $am = new ArticleManager();
                    $am->insert($article);
    
                    unset($_SESSION["error-message"]);
                    $this->redirect("index.php?route=admin");
                } else {
                    $_SESSION["error-message"] = "Une erreur s'est produite lors de la création de l'article";
                    $this->redirect("index.php?route=admin");
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                $_SESSION["error-message"] = "Une erreur s'est produite lors du téléchargement de l'image.";
                $this->redirect("index.php?route=admin");
            }
        } else {
            $_SESSION["error-message"] = "Champs manquants";
            $this->redirect("index.php?route=admin");
        }
    }
    
}
