<?php

class AdminUsersController extends AbstractController
{
    // Tous les utilisateurs
    public function users()
    {
        $um = new UserManager();

        $users = $um->findAll();

        $this->render("admin/admin-users.html.twig", [
            'users' => $users,
        ]);
    }


    // Un seul utilisateur
    public function user(int $id){

        $um = new UserManager();
        $user = $um->findOne($id);

        $om = new OrderManager();
        $orders = $om->allOrdersByUserId($id);

        $this->render("admin/admin-user.html.twig", [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    function newUser(){
        $this->render("admin/admin-new-user.html.twig", [
        ]);
    }

    public function addUser(){
        $id_user = null;
        if(isset($_POST)){
            $user = new User($_POST["firstName"],$_POST["lastName"],$_POST["email"],password_hash($_POST["password"], PASSWORD_BCRYPT),$_POST["address"],$_POST["city"],$_POST["postalCode"],$_POST["country"]);
            $um = new UserManager();
            $id_user = $um->create($user);
            if($id_user){
                $type = 'success';
                $text = $_POST['firstName'] . ' ' . $_POST['lastName'] . ' a bien été créé 😀';
                
            }else{
                $type = 'error';
                $text = "Un problème est survenu lors de la création de ce compte client.";
            }
        }else{
            $type = 'error';
            $text = "Un problème est survenu lors de la création de ce compte client.";
        }

        $this->notify($text,$type);

        if(!is_null($id_user) && $id_user){
            $this->redirect("/admin/users/$id_user");
        }else{
            $this->redirect("/admin/users/ne");
        }
    }

    public function updateUser()
    {
        $id = $_POST['id'];

        // Vérifie si les nouveaux mots de passe correspondent
        if ($_POST["password"] === $_POST["confirm-password"]) {
            // Vérifie la complexité du mot de passe
            $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
            if (preg_match($password_pattern, $_POST["password"])) {

                $user = new User($_POST["firstName"],$_POST["lastName"],$_POST["email"],password_hash($_POST["password"], PASSWORD_BCRYPT),$_POST["address"],$_POST["city"],$_POST["postalCode"],$_POST["country"]);
                $user->setId($id);

                // Initialise le gestionnaire d'utilisateurs et met à jour l'utilisateur dans la base de données
                $um = new UserManager();
                $um->update($user);

                $type = 'success';
                $text = "Le profil utilisateur a bien été mis à jour 😀";
                
            } elseif ($_POST["password"] !== null) {
                $type = 'error';
                $text = "Le mot de passe doit contenir au moins 8 caractères, comprenant au moins une lettre majuscule, un chiffre et un caractère spécial.";
            }
        } else {
            $type = 'error';
            $text = "Les mots de passe ne correspondent pas";
            
        }

        $this->notify($text,$type);
        $this->redirect("/admin/users/$id");
    }

    public function deleteUser()
    {
        if (isset($_SESSION["user"]) && isset($_POST['delete']) && isset($_POST['userId'])) {
            $user = $_SESSION["user"];
            $userId = $_POST["userId"];
            if ($userId !== null) {
                $um = new UserManager();
                $um->delete($userId); // Supprimer l'utilisateur

                // Vérifier si l'utilisateur supprimé n'est pas l'administrateur actuellement connecté
                if ($user->getRole() !== "ADMIN") {
                    session_destroy(); // Détruire la session si l'utilisateur supprimé n'est pas un administrateur
                    $this->redirect("/");
                } else { // Gestion des erreurs
                    $this->redirect("/admin");
                }
                unset($_SESSION["error-message"]);
            } else {
                $_SESSION["error-message"] = "Une erreur s'est produite lors de la suppression de l'utilisateur.";
                if ($user->getRole() === "ADMIN") {
                    $this->redirect("/admin-admin-users");
                } else {
                    $this->redirect("/account");
                }
            }
        } else {
            $_SESSION["error-message"] = "Une erreur s'est produite.";
            $this->redirect("/");
        }
    }
}
