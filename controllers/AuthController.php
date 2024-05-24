<?php

class AuthController extends AbstractController
{
    public function login() : void
    {   
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        unset($_SESSION["error-message"]);

        $this->render('account/login.html.twig', [
            'error' => $error,
            'csrf_token' => $_SESSION["csrf-token"],
            'error' => $error
        ]);
    }

    public function checkLogin() : void
    {
        if(isset($_POST["email"]) && isset($_POST["password"])) {
            $tokenManager = new CSRFTokenManager();
    
            // Vérifie si le jeton CSRF est valide
            if(isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"])) {
                $um = new UserManager();
                $user = $um->findByEmail($_POST["email"]);
    
                if($user !== null) {
                    // Vérifie si le mot de passe fourni correspond à celui stocké dans la base de données
                    if(password_verify($_POST["password"], $user->getPassword())){
                        $_SESSION["user"] = $user; // Connecte l'utilisateur en enregistrant ses données de session
                        unset($_SESSION["error-message"]);
                        $this->redirect("/");
                    } else {// Gestion des erreurs
                        $_SESSION["error-message"] = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                        $this->redirect("/login");
                    }
                } else {
                    $_SESSION["error-message"] = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                    $this->redirect("/login");
                }
            } else {
                $_SESSION["error-message"] = "token CSRF invalide";
                $this->redirect("/login");
            }
        } else {
            $_SESSION["error-message"] = "Champs manquants";
            $this->redirect("/login");
        }
    }
    
    public function register() : void
    {   
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        unset($_SESSION["error-message"]);

        $this->render('account/register.html.twig', [
            'error' => $error,
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
    
                            $um->create($user);
    
                            $_SESSION["user"] = $user; // Connecte l'utilisateur en enregistrant ses données de session
                            unset($_SESSION["error-message"]);
                            $this->redirect("/"); 
                        } else { // Gestion des erreurs
                            $_SESSION["error-message"] = "L'utilisateur existe déjà";
                            $this->redirect("/register");
                        }
                    } else {
                        $_SESSION["error-message"] = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                        $this->redirect("/register");
                    }
                } else {
                    $_SESSION["error-message"] = "Les mots de passe ne correspondent pas";
                    $this->redirect("/register");
                }
            } else {
                $_SESSION["error-message"] = "Token CSRF invalide";
                $this->redirect("/register");
            }
        } else {
            $_SESSION["error-message"] = "Champs manquants";
            $this->redirect("/register");
        }
    }
    
    public function admin(): void
    {
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        unset($_SESSION["error-message"]);

        $this->render('account/login-admin.html.twig', [
            'error' => $error,
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
                            unset($_SESSION["error-message"]);
                            $this->redirect("/admin");
                        } else { // Gestion des erreurs
                            $_SESSION["error-message"] = "Vous n’êtes pas autorisé à accéder à cette page";
                            $this->redirect("/login-admin");
                        }
                    } else {
                        $_SESSION["error-message"] = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                        $this->redirect("/login-admin");
                    }
                } else {
                    $_SESSION["error-message"] = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                    $this->redirect("/login-admin");
                }
            } else {
                $_SESSION["error-message"] = "Token CSRF invalide";
                $this->redirect("/login-admin");
            }
        } else {
            $_SESSION["error-message"] = "Champs manquants";
            $this->redirect("/login-admin");
        }
    }
    
    public function logout() : void
    {
        session_destroy();

        $this->redirect("/");
    }
}