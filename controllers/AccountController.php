<?php

class AccountController extends AbstractController
{
    public function account() : void
    {
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        $session = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
        $sessionId = null;
        $orders = [];
        $ordersArticles = [];
    
        if(isset($_SESSION["user"]) && $_SESSION["user"] instanceof User) {
            $sessionId = $_SESSION["user"]->getId();
            $om = new OrderManager();
            $orders = $om->findByUserId($sessionId);
            $ordersArticles = [];
    
            foreach ($orders as $order) {
                $orderId = $order->getId();
                $oAm = new OrderArticleManager();
                $orderArticles = $oAm->findByOrderId($orderId);
                $ordersArticles[$orderId] = $orderArticles;
            }
        }
    
        $this->render("account/account.html.twig", [
            'error' => $error,
            'session' => $session,
            'orders' => $orders,
            'ordersArticles' => $ordersArticles
        ]);
    }
    
    

    public function updateUserProfile() : void
    {
        if(isset($_SESSION['user']))
        {
            $currentUser = $_SESSION['user'];
            
            if(password_verify($_POST["password"], $currentUser->getPassword())) 
            {
                $_SESSION["error-message"] = "Le mot de passe ne peut pas etre le meme que l'ancien";
            }
            else
            {
                if($_POST["password"] === $_POST["confirm-password"])
                {  
                    $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
    
                    if (preg_match($password_pattern, $_POST["password"]))
                    {   
                        $currentUser->setFirstName(htmlspecialchars($_POST["firstName"]));
                        $currentUser->setLastName(htmlspecialchars($_POST["lastName"]));
                        $currentUser->setEmail(htmlspecialchars($_POST["email"]));
                        $currentUser->setPassword(password_hash($_POST["password"], PASSWORD_BCRYPT));
                        $currentUser->setAddress(htmlspecialchars($_POST["address"]));
                        $currentUser->setCity(htmlspecialchars($_POST["city"]));
                        $currentUser->setPostalCode(htmlspecialchars($_POST["postalCode"]));
                        $currentUser->setCountry(htmlspecialchars($_POST["country"]));
            
                        $um = new UserManager();
                        $um->update($currentUser);
            
                        $_SESSION["user"] = $currentUser;
                        unset($_SESSION["error-message"]);
                        $this->redirect("index.php");
            
                    }
                    elseif($_POST["password"] !== null)
                    {
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
                        unset($_SESSION["error-message"]);
                        $this->redirect("index.php");
                    }
                    else 
                    {
                        $_SESSION["error-message"] = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                    }
                }
                else
                {
                    $_SESSION["error-message"] = "Les mots de passe ne correspondent pas";
                }
            }
        }
        else
        {
            $_SESSION["error-message"] = "L'utilisateur n'est pas connecté.";
        }
    
        $this->redirect("index.php?route=account");
    }
}