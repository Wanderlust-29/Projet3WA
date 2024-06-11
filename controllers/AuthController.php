<?php

class AuthController extends AbstractController
{
    public function login(): void
    {
        $this->render('account/login.html.twig', [
            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }

    public function checkLogin(): void
    {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $tokenManager = new CSRFTokenManager();

            // Vérifie si le jeton CSRF est valide
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $um = new UserManager();
                $user = $um->findByEmail($_POST["email"]);

                if ($user !== null) {
                    // Vérifie si le mot de passe fourni correspond à celui stocké dans la base de données
                    if (password_verify($_POST["password"], $user->getPassword())) {
                        $_SESSION["user"] = $user; // Connecte l'utilisateur en enregistrant ses données de session
                        $type = 'success';
                        $text = "Bienvenue " . $user->getFirstName() . " !";

                        $this->redirect("/");
                    } else { // Gestion des erreurs
                        $type = 'error';
                        $text = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                        $this->redirect("/login");
                    }
                } else {
                    $type = 'error';
                    $text = "L'utilisateur n'existe pas";
                    $this->redirect("/login");
                }
            } else {
                $type = 'error';
                $text = "token CSRF invalide";
                $this->redirect("/login");
            }
        } else {
            $type = 'error';
            $text = "Champs manquants";
            $this->redirect("/login");
        }
        $this->notify($text, $type);
    }

    public function register(): void
    {
        $this->render('account/register.html.twig', [

            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }

    public function checkRegister(): void
    {
        if (
            isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"])
            && isset($_POST["password"]) && isset($_POST["confirm-password"]) && isset($_POST["address"])
            && isset($_POST["city"]) && isset($_POST["postalCode"]) && isset($_POST["country"])
        ) {
            // Vérifie si le jeton CSRF est valide
            $tokenManager = new CSRFTokenManager();
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                // Vérifie si les mots de passe correspondent
                if ($_POST["password"] === $_POST["confirm-password"]) {
                    // Vérifie si le mot de passe respecte le motif requis
                    $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
                    if (preg_match($password_pattern, $_POST["password"])) {
                        $um = new UserManager();
                        $user = $um->findByEmail($_POST["email"]);

                        if ($user === null) {
                            // Crée un nouvel utilisateur et le sauvegarde en base de données
                            $firstName = htmlspecialchars($_POST["firstName"]);
                            $lastName = htmlspecialchars($_POST["lastName"]);
                            $email = htmlspecialchars($_POST["email"]);
                            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                            $address = htmlspecialchars($_POST["address"]);
                            $city = htmlspecialchars($_POST["city"]);
                            $postalCode = htmlspecialchars($_POST["postalCode"]);
                            $country = htmlspecialchars($_POST["country"]);
                            $user = new User($firstName, $lastName, $email, $password, $address, $city, $postalCode, $country);

                            // Création de l'utilisateur dans la base de données et récupération de son ID
                            $userId = $um->create($user);

                            if ($userId !== null) {
                                // Attribution de l'ID à l'objet utilisateur
                                $user->setId($userId);

                                // Stockage de l'utilisateur dans la session
                                $_SESSION["user"] = $user;

                                // Redirection vers la page d'accueil ou autre page appropriée
                                $this->redirect("/");
                            } else {
                                // Gestion des erreurs en cas d'échec de la création de l'utilisateur
                                $type = 'error';
                                $text = "Erreur lors de la création de l'utilisateur.";
                                $this->notify($text, $type);
                                $this->redirect("/register");
                            }
                        } else { // Gestion des erreurs
                            $text = "L'utilisateur existe déjà";
                            $this->redirect("/register");
                        }
                    } else {
                        $type = 'error';
                        $text = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                        $this->redirect("/register");
                    }
                } else {
                    $type = 'error';
                    $text = "Les mots de passe ne correspondent pas";
                    $this->redirect("/register");
                }
            } else {
                $type = 'error';
                $text = "Token CSRF invalide";
                $this->redirect("/register");
            }
        } else {
            $type = 'error';
            $text = "Champs manquants";
            $this->redirect("/register");
        }
        $this->notify($text, $type);
    }


    public function loginAdmin(): void
    {
        $this->render('layout.admin-login.html.twig', [
            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }

    public function checkAdmin(): void
    {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $tokenManager = new CSRFTokenManager();

            // Vérifie si le jeton CSRF est valide
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $um = new UserManager();
                $user = $um->findByEmail($_POST["email"]);

                if ($user !== null) {
                    // Vérifie si le mot de passe fourni correspond à celui stocké dans la base de données
                    if (password_verify($_POST["password"], $user->getPassword())) {
                        // Vérifie si l'utilisateur est un administrateur
                        if ($user->getRole() === "ADMIN") {
                            $_SESSION["user"] = $user; // Connecte l'utilisateur en enregistrant ses données de session
                            $type = "success";
                            $text = "Bienvenue " . $user->getFirstName() . " !";
                            $this->redirect("/admin");
                        } else { // Gestion des erreurs
                            $type = "error";
                            $text = "Vous n’êtes pas autorisé à accéder à cette page";
                            $this->redirect("/");
                        }
                    } else {
                        $type = "error";
                        $text = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                        $this->redirect("/login-admin");
                    }
                } else {
                    $type = "error";
                    $text = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                    $this->redirect("/login-admin");
                }
            } else {
                $type = "error";
                $text = "Token CSRF invalide";
                $this->redirect("/login-admin");
            }
        } else {
            $type = "error";
            $text = "Champs manquants";
            $this->redirect("/login-admin");
        }
        $this->notify($text, $type);
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect("/");
    }
}
