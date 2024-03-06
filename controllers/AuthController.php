<?php

class AuthController extends AbstractController
{
    public function login() : void
    {   
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $this->render('account/login.html.twig', [
            'error' => $error,
            'csrf_token' => $_SESSION["csrf-token"],
            'session' => $session
        ]);
    }

    public function checkLogin() : void
    {
        if(isset($_POST["email"]) && isset($_POST["password"]))
        {
            $tokenManager = new CSRFTokenManager();

            if(isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
                $um = new UserManager();
                $user = $um->findByEmail($_POST["email"]);

                if($user !== null)
                {
                    if(password_verify($_POST["password"], $user->getPassword()))
                    {
                        $_SESSION["user"] = $user;
                        unset($_SESSION["error-message"]);
                        $this->redirect("index.php");
                    }
                    else
                    {
                        $_SESSION["error-message"] = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                        $this->redirect("index.php?route=login");
                    }
                }
                else
                {
                    $_SESSION["error-message"] = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                    $this->redirect("index.php?route=login");
                }
            }
            else
            {
                $_SESSION["error-message"] = "token CSRF invalide";
                $this->redirect("index.php?route=login");
            }
        }
        else
        {
            $_SESSION["error-message"] = "Champs manquants";
            $this->redirect("index.php?route=login");
        }
    }

    public function register() : void
    {   
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $this->render('account/register.html.twig', [
            'error' => $error,
            'csrf_token' => $_SESSION["csrf-token"],  
            'session' => $session
        ]);
    }

    public function checkRegister() : void
    {
        if(isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"])
            && isset($_POST["password"]) && isset($_POST["confirm-password"]) && isset($_POST["address"])
            && isset($_POST["city"]) && isset($_POST["postalCode"]) && isset($_POST["country"]))
        {
            $tokenManager = new CSRFTokenManager();
            if(isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
                if($_POST["password"] === $_POST["confirm-password"])
                {
                    $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';

                    if (preg_match($password_pattern, $_POST["password"]))
                    {
                        $um = new UserManager();
                        $user = $um->findByEmail($_POST["email"]);

                        if($user === null)
                        {
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

                            $_SESSION["user"] = $user;
                            unset($_SESSION["error-message"]);
                            $this->redirect("index.php");
                        }
                        else
                        {
                            $_SESSION["error-message"] = "L'utilisateur existe déjà";
                            $this->redirect("index.php?route=register");
                        }
                    }
                    else {
                        $_SESSION["error-message"] = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                        $this->redirect("index.php?route=register");
                    }
                }
                else
                {
                    $_SESSION["error-message"] = "Les mots de passes ne correspondent pas";
                    $this->redirect("index.php?route=register");
                }
            }
            else
            {
                $_SESSION["error-message"] = "token CSRF invalide";
                $this->redirect("index.php?route=register");
            }
        }
        else
        {
            $_SESSION["error-message"] = "Champs manquants";
            $this->redirect("index.php?route=register");
        }
    }

    public function admin() : void
    {
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $this->render('account/admin.html.twig', [
            'error' => $error,
            'csrf_token' => $_SESSION["csrf-token"],  
            'session' => $session
        ]);
    }

    public function checkAdmin() : void
    {
        if(isset($_POST["email"]) && isset($_POST["password"]))
        {
            $tokenManager = new CSRFTokenManager();

            if(isset($_POST["csrf-token"]) && $tokenManager->validateCSRFToken($_POST["csrf-token"]))
            {
                $um = new UserManager();
                $user = $um->findByEmail($_POST["email"]);

                if($user !== null)
                {
                    if(password_verify($_POST["password"], $user->getPassword()))
                    {   
                        if ($user->getRole() === "ADMIN")
                        {
                            $_SESSION["user"] = $user;
                            unset($_SESSION["error-message"]);
                            $this->redirect("index.php?route=accountAdmin");
                        }
                        else
                        {
                            $_SESSION["error-message"] = "Vous n’êtes pas autorisé à accéder à cette page";
                            $this->redirect("index.php?route=admin");
                        }
                    }
                    else
                    {
                        $_SESSION["error-message"] = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                        $this->redirect("index.php?route=admin");
                    }
                }
                else
                {
                    $_SESSION["error-message"] = "Mot de passe ou adresse e-mail incorrect. Veuillez réessayer.";
                    $this->redirect("index.php?route=admin");
                }
            }
            else
            {
                $_SESSION["error-message"] = "token CSRF invalide";
                $this->redirect("index.php?route=admin");
            }
        }
        else
        {
            $_SESSION["error-message"] = "Champs manquants";
            $this->redirect("index.php?route=admin");
        }
    }
    
    public function logout() : void
    {
        session_destroy();

        $this->redirect("index.php");
    }
}