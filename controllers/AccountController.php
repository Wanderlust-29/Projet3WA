<?php

use Cocur\Slugify\Slugify;

class AccountController extends AbstractController
{
    /**
     * Renders the user account page.
     * Displays the latest order details if the user is logged in.
     */
    public function account(): void
    {
        $sessionId = null;

        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId();

            if ($sessionId !== null) {
                $om = new OrderManager();
                $order = $om->findLastOrder($sessionId);

                if ($order) {
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
                $this->render("account/account.html.twig", [
                    'order' => null,
                ]);
            }
        } else {
            $this->render("account/account.html.twig", [
                'order' => null,
            ]);
        }
    }

    /**
     * Retrieves and displays all orders of the logged-in user.
     */
    public function orders(): void
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId();

            if ($sessionId !== null) {
                $om = new OrderManager();
                $allOrders = $om->allOrdersByUserId($sessionId);

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
                    error_log('No orders found for the user.');
                    $this->render("account/orders.html.twig", [
                        'orders' => [],
                    ]);
                }
            } else {
                error_log('No orders found for the user.');
                $this->render("account/orders.html.twig", [
                    'orders' => [],
                ]);
            }
        } else {
            error_log('No user found in session or user is not an instance of User class.');
            $this->redirect(url('login'));
        }
    }

    /**
     * Renders the account information page.
     */
    public function infos(): void
    {
        $this->render("account/infos.html.twig", []);
    }

    /**
     * Retrieves and displays a specific order for the logged-in user.
     * @param int $id The ID of the order to display.
     */
    public function order(int $id): void
    {
        if (isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId();
            $om = new OrderManager();
            $order = $om->findOneForAccount($id, $sessionId);

            if (!is_null($order)) {
                $date = $order->getCreatedAt();
                $created_at = AbstractController::niceDate($date);
                $order->setNiceDate($created_at);
                $ago = AbstractController::diffDate($date);
                $order->setDiffDate($ago);

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

    /**
     * Updates the user profile information based on form input.
     * Redirects to the account info page after updating.
     */
    public function updateUserProfile(): void
    {
        if (isset($_SESSION['user'])) {
            $tokenManager = new CSRFTokenManager();

            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $currentUser = $_SESSION['user'];

                $currentUser->setFirstName(htmlspecialchars($_POST["firstName"]));
                $currentUser->setLastName(htmlspecialchars($_POST["lastName"]));
                $currentUser->setEmail(htmlspecialchars($_POST["email"]));
                $currentUser->setAddress(htmlspecialchars($_POST["address"]));
                $currentUser->setCity(htmlspecialchars($_POST["city"]));
                $currentUser->setPostalCode(htmlspecialchars($_POST["postalCode"]));
                $currentUser->setCountry(htmlspecialchars($_POST["country"]));

                $um = new UserManager();
                $um->update($currentUser);

                $_SESSION["user"] = $currentUser;
                $type = 'success';
                $text = "Profil mis à jour";
                $this->redirect("infos");
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

    /**
     * Updates the user password based on form input.
     * Redirects to the account info page after updating.
     */
    public function updateUserPassword(): void
    {
        if (isset($_POST["password"]) && isset($_POST["confirm-password"])) {
            $currentUser = $_SESSION['user'];
            $tokenManager = new CSRFTokenManager();

            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                if ($_POST["password"] !== $_POST["confirm-password"]) {
                    $type = "error";
                    $text = "Les mots de passe ne correspondent pas";
                    $this->redirect("infos");
                } else {
                    if (!empty($_POST["password"])) {
                        $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';

                        if (!preg_match($password_pattern, $_POST["password"])) {
                            $type = "error";
                            $text = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                        } else {
                            if ($_POST["password"] === $_POST["confirm-password"]) {
                                $currentUser->setPassword(password_hash($_POST["password"], PASSWORD_BCRYPT));

                                $um = new UserManager();
                                $um->update($currentUser);

                                $_SESSION["user"] = $currentUser;
                                $type = 'success';
                                $text = "Mot de passe mis à jour";
                                $this->redirect("infos");
                            }
                        }
                    } else {
                        $type = "error";
                        $text = "Des champs sont vides";
                        $this->redirect("infos");
                    }
                }
            } else {
                $this->redirect("/login");
                $type = "error";
                $text = "Token CSRF invalide";
            }
        } else {
            $this->redirect("infos");
        }

        $this->notify($text, $type);
    }

    /**
     * Deletes the user profile.
     * Logs out the user and redirects to login page after deletion.
     */
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

    /**
     * Renders the page to add a new comment on an article.
     * @param string $slug The slug of the article to comment on.
     */
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

    /**
     * Processes and adds a new comment on an article.
     * Redirects to the account page after adding the comment.
     * @param string $slug The slug of the article to comment on.
     */
    public function checkComment(string $slug): void
    {
        if (isset($_POST["grade"]) && isset($_POST["comment"])) {
            $tokenManager = new CSRFTokenManager();
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                if (isset($_SESSION['user'])) {
                    // The $user object with the information of the logged-in user
                    $userId = $_SESSION['user']->getId();

                    $userManager = new UserManager();
                    $user = $userManager->findOne($userId);

                    $cm = new CommentManager();

                    $am = new ArticleManager();
                    $article = $am->findBySlug($slug);

                    // Create a new comment
                    $grade = $_POST["grade"];
                    $commentText = htmlspecialchars($_POST["comment"]);
                    $comment = new Comment($article, $user, $grade, $commentText);
                    $cm->create($comment);
                    $type = 'success';
                    $text = "Votre commentaire à été pris en compte";

                    // Redirect after creating the comment
                    $this->redirect("/account");
                } else {
                    // Redirect if the user is not logged in
                    $type = 'error';
                    $text = "Vous devez être connecté pour commenter.";
                    $this->redirect("/");
                }
            } else {
                // Redirect if the CSRF token is invalid
                $type = 'error';
                $text = "Token CSRF invalide.";
                $this->redirect("/login");
            }
        } else {
            // Redirect if the comment data is incomplete
            $type = 'error';
            $text = "Veuillez remplir tous les champs du commentaire.";
            $this->redirect("/");
        }
        $this->notify($text, $type);
    }
}
