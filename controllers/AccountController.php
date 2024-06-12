<?php

use Cocur\Slugify\Slugify;

class AccountController extends AbstractController
{
    // USER
    public function account(): void
    {
        $sessionId = null;

        // Vérifie si un utilisateur est connecté en session et s'il s'agit bien d'une instance de la classe User
        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId(); // Récupère l'identifiant de l'utilisateur connecté
            // dump($sessionId);

            if ($sessionId !== null) { // Ensure $sessionId is not null
                $om = new OrderManager(); // Initialise le gestionnaire de commandes
                $order = $om->findLastOrder($sessionId); // Récupère les commandes de l'utilisateur

                if ($order) {
                    // If an order is found
                    $date = $order->getCreatedAt();
                    $created_at = AbstractController::niceDate($date);
                    $order->setNiceDate($created_at);
                    $ago = AbstractController::diffDate($date);
                    $order->setDiffDate($ago);
                }

                $this->render("account/account.html.twig", [
                    'order' => $order,
                ]);
            } else {
                // Handle case where sessionId is null
                $this->render("account/account.html.twig", [
                    'order' => null,
                ]);
            }
        } else {
            // Handle case where user is not logged in or session user is not an instance of User
            $this->render("account/account.html.twig", [
                'order' => null,
            ]);
        }
    }


    // TOUTES LES COMMANDES
    public function orders(): void
    {
        // Vérifie si un utilisateur est connecté en session et s'il s'agit bien d'une instance de la classe User
        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId(); // Récupère l'identifiant de l'utilisateur connecté

            if ($sessionId !== null) {
                $om = new OrderManager(); // Initialise le gestionnaire de commandes
                $allOrders = $om->allOrdersByUserId($sessionId); // Récupère les commandes de l'utilisateur

                // Vérifie s'il y a des commandes pour l'utilisateur
                if (!empty($allOrders)) {
                    foreach ($allOrders as $order) {
                        $date = $order->getCreatedAt();
                        $created_at = AbstractController::niceDate($date);
                        $order->setNiceDate($created_at);
                        $ago = AbstractController::diffDate($date);
                        $order->setDiffDate($ago);
                        $orders[] = $order;
                    }

                    $this->render("account/orders.html.twig", [
                        'orders' => $orders,
                    ]);
                } else {
                    // Log an error message if no orders found for the user
                    error_log('No orders found for the user.');
                    $this->render("account/orders.html.twig", [
                        'orders' => [], // Pass an empty array of orders
                    ]);
                }
            } else {
                error_log('No orders found for the user.');
                $this->render("account/orders.html.twig", [
                    'orders' => [], // Pass an empty array of orders
                ]);
            }
        } else {
            // Log an error message if the user is not in the session or is not an instance of User
            error_log('No user found in session or user is not an instance of User class.');
            $this->redirect(url('login')); // Redirect to login page if user is not logged in
        }
    }


    // MODIFICATION INFORMATIONS
    public function infos(): void
    {
        $this->render("account/infos.html.twig", []);
    }

    // Récupération d'une commande passée pour un compte client
    public function order(int $id): void
    {
        // Vérifie si un utilisateur est connecté en session et s'il s'agit bien d'une instance de la classe User
        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId(); // Récupère l'identifiant de l'utilisateur connecté
            $om = new OrderManager();
            // Initialise le gestionnaire de commandes
            $order = $om->findOneForAccount($id, $sessionId);
            if (!is_null($order)) {
                $date = $order->getCreatedAt();
                $created_at = AbstractController::niceDate($date);
                $order->setNiceDate($created_at);
                $ago = AbstractController::diffDate($date);
                $order->setDiffDate($ago);

                //Récupération des articles
                $articles = $om->orderArticle($id);

                $this->render("account/order.html.twig", [
                    'order' => $order,
                    'articles' => $articles
                ]);
            } else {
                $this->redirect(url('userOrders'));
            }
        }
    }

    // MISE A JOUR INFORMATION PROFIL
    public function updateUserProfile(): void
    {
        if (isset($_SESSION['user'])) {
            $tokenManager = new CSRFTokenManager();

            // Vérifie si le jeton CSRF est valide
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $currentUser = $_SESSION['user'];

                // Met à jour les informations du profil utilisateur
                $currentUser->setFirstName(htmlspecialchars($_POST["firstName"]));
                $currentUser->setLastName(htmlspecialchars($_POST["lastName"]));
                $currentUser->setEmail(htmlspecialchars($_POST["email"]));
                $currentUser->setAddress(htmlspecialchars($_POST["address"]));
                $currentUser->setCity(htmlspecialchars($_POST["city"]));
                $currentUser->setPostalCode(htmlspecialchars($_POST["postalCode"]));
                $currentUser->setCountry(htmlspecialchars($_POST["country"]));

                // Initialise le gestionnaire d'utilisateurs et met à jour l'utilisateur dans la base de données
                $um = new UserManager();
                $um->update($currentUser);

                // Met à jour la session utilisateur et réinitialise le message d'erreur
                $_SESSION["user"] = $currentUser;
                $type = 'success';
                $text = "Profil mis à jour";
                $this->redirect("account/infos");
            } else {
                $type = "error";
                $text = "Token CSRF invalide";
                $this->redirect("/login");
            }
        } else {
            $type = 'error';
            $text = "L'utilisateur n'est pas connecté.";
            $this->redirect("/");
        }

        $this->notify($text, $type);
    }

    // MISE A JOUR MOT DE PASSE
    public function updateUserPassword(): void
    {
        if (isset($_POST["password"]) && isset($_POST["confirm-password"])) {
            $currentUser = $_SESSION['user'];
            $tokenManager = new CSRFTokenManager();

            // Vérifie si le jeton CSRF est valide
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                // Vérifie si les nouveaux mots de passe correspondent
                if ($_POST["password"] !== $_POST["confirm-password"]) {
                    $type = "error";
                    $text = "Les mots de passe ne correspondent pas";
                } else {
                    // Vérifie la complexité du mot de passe si le champ password n'est pas vide
                    if (!empty($_POST["password"])) {
                        $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';

                        if (!preg_match($password_pattern, $_POST["password"])) {
                            $type = "error";
                            $text = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                        } else {
                            // Met à jour le mot de passe uniquement si les champs ne sont pas vides et correspondent
                            if ($_POST["password"] === $_POST["confirm-password"]) {
                                $currentUser->setPassword(password_hash($_POST["password"], PASSWORD_BCRYPT));

                                // Initialise le gestionnaire d'utilisateurs et met à jour l'utilisateur dans la base de données
                                $um = new UserManager();
                                $um->update($currentUser);

                                // Met à jour la session utilisateur et réinitialise le message d'erreur
                                $_SESSION["user"] = $currentUser;
                                $type = 'success';
                                $text = "Mot de passe mis à jour";
                            }
                        }
                    } else {
                        $type = "error";
                        $text = "Des champs sont vides";
                        // Si les champs du mot de passe sont vides, rediriger vers la page d'infos du compte
                        $this->redirect("/account/infos");
                    }
                }
            } else {
                // Si le jeton CSRF est invalide, rediriger vers la page de connexion
                $this->redirect("/login");
                $type = "error";
                $text = "Token CSRF invalide";
            }
        } else {
            // Si les champs du mot de passe ne sont pas définis, rediriger vers la page d'infos du compte
            $this->redirect("/account/infos");
        }

        // Notifie l'utilisateur en fonction du résultat
        $this->notify($text, $type);
    }


    // DELETE PROFIL
    public function deleteUserProfile(): void
    {

        if (isset($_SESSION["user"]) && isset($_POST['delete']) && isset($_POST['userId'])) {

            $userId = $_SESSION["user"]->getId();

            if ($userId) {
                $um = new UserManager();
                $um->delete($userId);
                $type = 'success';
                $text = "Votre compte à bien été supprimé";
                session_destroy();
                $this->redirect("/login");
            } else {
                $type = 'error';
                $text = "Une erreur s'est produite lors de la suppression de l'utilisateur.";
                $this->redirect("/");
            }
        } else {
            $type = 'error';
            $text = "Une erreur s'est produite.";
            $this->redirect("/");
        }
        $this->notify($text, $type);
    }

    public function newComment(string $slug): void
    {

        $am = new ArticleManager();
        $cm = new CommentManager();

        $article = $am->findBySlug($slug);

        $this->render("account/comment.html.twig", [
            "article" => $article,
            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }

    public function checkComment($slug): void
    {
        if (isset($_POST["grade"]) && isset($_POST["comment"])) {
            $tokenManager = new CSRFTokenManager();
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                if (isset($_SESSION['user'])) {
                    // L'objet $user avec les informations de l'utilisateur connecté
                    $userId = $_SESSION['user']->getId();

                    $userManager = new UserManager();
                    $user = $userManager->findOne($userId);

                    $cm = new CommentManager();

                    $am = new ArticleManager();
                    $article = $am->findBySlug($slug);

                    // Crée un nouveau commentaire
                    $grade = $_POST["grade"];
                    $commentText = htmlspecialchars($_POST["comment"]);
                    $comment = new Comment($article, $user, $grade, $commentText);
                    $cm->create($comment);
                    $type = 'success';
                    $text = "Votre commentaire à été pris en compte";

                    // Redirection après la création du commentaire
                    $this->redirect("/account");
                } else {
                    // Redirection si l'utilisateur n'est pas connecté
                    $type = 'error';
                    $text = "Vous devez être connecté pour commenter.";
                    $this->redirect("/");
                }
            } else {
                // Redirection si le token CSRF est invalide
                $type = 'error';
                $text = "Token CSRF invalide.";
                $this->redirect("/login");
            }
        } else {
            // Redirection si les données de commentaire ne sont pas complètes
            $type = 'error';
            $text = "Veuillez remplir tous les champs du commentaire.";
            $this->redirect("/");
        }
        $this->notify($text, $type);
    }
}
