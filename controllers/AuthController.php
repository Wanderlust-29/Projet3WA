<?php

class AuthController extends AbstractController
{
    /**
     * Renders the login form.
     */
    public function login(): void
    {
        $this->render('account/login.html.twig', [
            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }

    /**
     * Handles the login form submission and user authentication.
     */
    public function checkLogin(): void
    {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $tokenManager = new CSRFTokenManager();

            // Check if CSRF token is valid
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $um = new UserManager();
                $user = $um->findByEmail($_POST["email"]);

                if ($user !== null) {
                    // Check if provided password matches the one stored in the database
                    if (password_verify($_POST["password"], $user->getPassword())) {
                        $_SESSION["user"] = $user; // Log in the user by storing their session data
                        $type = 'success';
                        $text = "Bienvenue " . $user->getFirstName() . " !";

                        $this->redirect("/");
                    } else { // Error handling
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
                $text = "Token CSRF invalide";
                $this->redirect("/login");
            }
        } else {
            $type = 'error';
            $text = "Champs manquants";
            $this->redirect("/login");
        }
        $this->notify($text, $type);
    }

    /**
     * Renders the registration form.
     */
    public function register(): void
    {
        $this->render('account/register.html.twig', [
            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }

    /**
     * Handles the registration form submission and user creation.
     */
    public function checkRegister(): void
    {
        if (
            isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"])
            && isset($_POST["password"]) && isset($_POST["confirm-password"]) && isset($_POST["address"])
            && isset($_POST["city"]) && isset($_POST["postalCode"]) && isset($_POST["country"])
        ) {
            // Check if CSRF token is valid
            $tokenManager = new CSRFTokenManager();
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                // Check if passwords match
                if ($_POST["password"] === $_POST["confirm-password"]) {
                    // Check if password meets required pattern
                    $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
                    if (preg_match($password_pattern, $_POST["password"])) {
                        $um = new UserManager();
                        $user = $um->findByEmail($_POST["email"]);

                        if ($user === null) {
                            // Create a new user and save it to the database
                            $firstName = htmlspecialchars($_POST["firstName"]);
                            $lastName = htmlspecialchars($_POST["lastName"]);
                            $email = htmlspecialchars($_POST["email"]);
                            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
                            $address = htmlspecialchars($_POST["address"]);
                            $city = htmlspecialchars($_POST["city"]);
                            $postalCode = htmlspecialchars($_POST["postalCode"]);
                            $country = htmlspecialchars($_POST["country"]);
                            $user = new User($firstName, $lastName, $email, $password, $address, $city, $postalCode, $country);

                            // Create the user in the database and get their ID
                            $userId = $um->create($user);

                            if ($userId !== null) {
                                // Assign the ID to the user object
                                $user->setId($userId);

                                // Store the user in the session
                                $_SESSION["user"] = $user;

                                // Redirect to homepage or appropriate page
                                $this->redirect("/");
                            } else {
                                // Error handling in case user creation fails
                                $type = 'error';
                                $text = "Erreur lors de la création de l'utilisateur.";
                                $this->notify($text, $type);
                                $this->redirect("/register");
                            }
                        } else { // Error handling
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

    /**
     * Renders the admin login form.
     */
    public function loginAdmin(): void
    {
        $this->render('layout.admin-login.html.twig', [
            'csrf_token' => $_SESSION["csrf-token"],
        ]);
    }

    /**
     * Handles the admin login form submission and authentication.
     */
    public function checkAdmin(): void
    {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            $tokenManager = new CSRFTokenManager();

            // Check if CSRF token is valid
            if (isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $um = new UserManager();
                $user = $um->findByEmail($_POST["email"]);

                if ($user !== null) {
                    // Check if provided password matches the one stored in the database
                    if (password_verify($_POST["password"], $user->getPassword())) {
                        // Check if the user is an admin
                        if ($user->getRole() === "ADMIN") {
                            $_SESSION["user"] = $user; // Log in the user by storing their session data
                            $type = "success";
                            $text = "Bienvenue " . $user->getFirstName() . " !";
                            $this->redirect("/admin");
                        } else { // Error handling
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

    /**
     * Logs out the user by destroying the session.
     */
    public function logout(): void
    {
        session_destroy();
        $this->redirect("/");
    }
}
