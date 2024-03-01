<?php

class AuthController extends AbstractController
{
    public function login() : void
    {   
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        
        $this->render('login.html.twig', [
            'error' => $error,
            'csrf_token' => $_SESSION["csrf-token"]
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
                        $_SESSION["user"] = $user->getId();

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
        
        $this->render('register.html.twig', [
            'error' => $error,
            'csrf_token' => $_SESSION["csrf-token"]
        ]);
    }
    public function checkRegister() : void
    {

    }

    public function logout() : void
    {
        session_destroy();

        $this->redirect("index.php");
    }
}