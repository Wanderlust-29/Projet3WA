<?php
use Cocur\Slugify\Slugify;

class AccountController extends AbstractController
{
    // USER
    public function account(): void
    {
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;

        $sessionId = null;
        $orders = [];
        $ordersArticles = [];

        // Vérifie si un utilisateur est connecté en session et s'il s'agit bien d'une instance de la classe User
        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId(); // Récupère l'identifiant de l'utilisateur connecté
            $om = new OrderManager();
            // Initialise le gestionnaire de commandes
            $orders = $om->allOrdersByUserId($sessionId); // Récupère les commandes de l'utilisateur

            foreach ($orders as $order) {
                $orderId = $order->getId();
                $orderArticle = $om->orderArticle($orderId);
                $ordersArticles[$orderId] = $orderArticle;
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
                        $this->redirect("/");
                    } elseif ($_POST["password"] !== null) {
                        $_SESSION["error-message"] = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                        $this->redirect("/admin");
                    }
                } else {
                    $_SESSION["error-message"] = "Les mots de passe ne correspondent pas";
                    $this->redirect("/admin");
                }
            }
        } else {
            $_SESSION["error-message"] = "L'utilisateur n'est pas connecté.";
        }
        $this->redirect("/account");
    }


    public function newComment($articleId): void
    {
        $am = new ArticleManager();

        $article = $am->findOne(intval($articleId));

        $this->render("account/comment.html.twig", [
            "article" => $article,
        ]);
    }

    public function checkComment($articleId): void
    {
        if (isset($_POST["grade"]) && isset($_POST["comment"])) {

            if (isset($_SESSION['user'])) {
                // L'objet $user avec les informations de l'utilisateur connecté
                $userId = $_SESSION['user']->getId();

                $userManager = new UserManager();
                $user = $userManager->findOne(($userId));

                $cm = new CommentManager();

                $am = new ArticleManager();
                $article = $am->findOne(intval($articleId));

                // Crée un nouveau commentaire
                $grade = $_POST["grade"];
                $commentText = htmlspecialchars($_POST["comment"]);
                $comment = new Comment($article, $user, $grade, $commentText);
                $cm->create($comment);
                $this->redirect("/account");
            } else {
                // Redirection si l'utilisateur n'est pas connecté
                $_SESSION["error-message"] = "Vous devez être connecté pour commenter.";
                $this->redirect("/");
            }
        } else {
            // Redirection si les données de commentaire ne sont pas complètes
            $_SESSION["error-message"] = "Veuillez remplir tous les champs du commentaire.";
            $this->redirect("/");
        }
    }
}
