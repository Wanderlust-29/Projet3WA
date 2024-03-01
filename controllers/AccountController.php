<?php

class AccountController extends AbstractController
{
    public function account() : void
    {
        $user = isset($_SESSION["user"]) ? $_SESSION["user"] : null;

        $this->render("account.html.twig", [
            'user' => $user
        ]);
    }

    public function updateUserProfile() : void
    {
        if(isset($_SESSION['user']))
        {
            $currentUser = $_SESSION['user']; // Récupérer l'utilisateur actuel depuis la session
    
            if($_POST["password"] === $_POST["confirm-password"])
            {
                $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
    
                if (preg_match($password_pattern, $_POST["password"]))
                {
                    // Mise à jour des propriétés de l'utilisateur actuel
                    $currentUser->setFirstName(htmlspecialchars($_POST["firstName"]));
                    $currentUser->setLastName(htmlspecialchars($_POST["lastName"]));
                    $currentUser->setEmail(htmlspecialchars($_POST["email"]));
                    $currentUser->setPassword(password_hash($_POST["password"], PASSWORD_BCRYPT));
                    $currentUser->setAddress(htmlspecialchars($_POST["address"]));
                    $currentUser->setCity(htmlspecialchars($_POST["city"]));
                    $currentUser->setPostalCode(htmlspecialchars($_POST["postalCode"]));
                    $currentUser->setCountry(htmlspecialchars($_POST["country"]));
    
                    // Appel de la fonction update du gestionnaire UserManager
                    $um = new UserManager();
                    $um->update($currentUser);
    
                    $_SESSION["user"] = $currentUser;
                    unset($_SESSION["error-message"]);
                    $this->redirect("index.php");
                }
                else {
                    $_SESSION["error-message"] = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
                }
            }
            else
            {
                $_SESSION["error-message"] = "Les mots de passe ne correspondent pas";
            }
        }
        else
        {
            $_SESSION["error-message"] = "L'utilisateur n'est pas connecté.";
        }
    
        $this->redirect("index.php?route=account");
    }
}