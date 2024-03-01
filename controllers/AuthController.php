<?php

class AuthController extends AbstractController
{
    public function login() : void
    {   
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $user = null;

        if (isset($_SESSION["user_id"])) {
            $um = new UserManager();
            $user_id = $_SESSION["user_id"];
            $user = $um->findOne($user_id);
        }

        $this->render('login.html.twig', [
            'error' => $error,
            'csrf_token' => $_SESSION["csrf-token"],
            'user' => $user,
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
        $user = null;

        if (isset($_SESSION["user_id"])) {
            $um = new UserManager();
            $user_id = $_SESSION["user_id"];
            $user = $um->findOne($user_id);
        }

        $this->render('register.html.twig', [
            'error' => $error,
            'csrf_token' => $_SESSION["csrf-token"],
            'user' => $user,
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
                            $_SESSION["error-message"] = "User already exists";
                            $this->redirect("index.php?route=register");
                        }
                    }
                    else {
                        $_SESSION["error-message"] = "Password is not strong enough";
                        $this->redirect("index.php?route=register");
                    }
                }
                else
                {
                    $_SESSION["error-message"] = "The passwords do not match";
                    $this->redirect("index.php?route=register");
                }
            }
            else
            {
                $_SESSION["error-message"] = "Invalid CSRF token";
                $this->redirect("index.php?route=register");
            }
        }
        else
        {
            $_SESSION["error-message"] = "Missing fields";
            $this->redirect("index.php?route=register");
        }
    }

    public function logout() : void
    {
        session_destroy();

        $this->redirect("index.php");
    }
}