<?php

class AdminUsersController extends AbstractController
{
    /**
     * Renders the page with all users.
     */
    public function users(): void
    {
        $um = new UserManager();
        $users = $um->findAll();

        $this->render("admin/admin-users.html.twig", [
            'users' => $users,
        ]);
    }

    /**
     * Renders the page for a specific user and their orders.
     * 
     * @param int $id The ID of the user to display
     */
    public function user(int $id): void
    {
        $um = new UserManager();
        $id = (int)$id;
        $user = $um->findOne($id);

        $om = new OrderManager();
        $orders = $om->allOrdersByUserId($id);

        $this->render("admin/admin-user.html.twig", [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    /**
     * Renders the form for creating a new user.
     */
    public function newUser()
    {
        $this->render("admin/admin-new-user.html.twig", []);
    }

    /**
     * Handles the form submission for creating a new user.
     */
    public function addUser(): void
    {
        $id_user = null;
        if (isset($_POST)) {
            $user = new User($_POST["firstName"], $_POST["lastName"], $_POST["email"], password_hash($_POST["password"], PASSWORD_BCRYPT), $_POST["address"], $_POST["city"], $_POST["postalCode"], $_POST["country"]);
            $um = new UserManager();
            $id_user = $um->create($user);
            if ($id_user) {
                $type = 'success';
                $text = $_POST['firstName'] . ' ' . $_POST['lastName'] . ' a bien été créé 😀';
            } else {
                $type = 'error';
                $text = "Un problème est survenu lors de la création de ce compte client.";
            }
        } else {
            $type = 'error';
            $text = "Un problème est survenu lors de la création de ce compte client.";
        }

        $this->notify($text, $type);

        if (!is_null($id_user) && $id_user) {
            $this->redirect("/admin/users/$id_user");
        } else {
            $this->redirect("/admin/users/ne");
        }
    }

    /**
     * Handles updating a user's profile information.
     */
    public function updateUser(): void
    {
        $id = $_POST['id'];

        // Checks if the new passwords match
        if ($_POST["password"] === $_POST["confirm-password"]) {
            // Checks password complexity
            $password_pattern = '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
            if (preg_match($password_pattern, $_POST["password"])) {

                $user = new User($_POST["firstName"], $_POST["lastName"], $_POST["email"], password_hash($_POST["password"], PASSWORD_BCRYPT), $_POST["address"], $_POST["city"], $_POST["postalCode"], $_POST["country"]);
                $user->setId($id);

                // Initializes the user manager and updates the user in the database
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

        $this->notify($text, $type);
        $this->redirect("/admin/users/$id");
    }

    /**
     * Handles deleting a user.
     */
    public function deleteUser(): void
    {
        if (isset($_SESSION["user"]) && isset($_POST['delete']) && isset($_POST['userId'])) {

            $user = $_SESSION["user"];
            $userId = (int)$_POST["userId"]; // Ensure userId is an integer

            if ($userId > 0) {
                $um = new UserManager();
                $um->delete($userId); // Delete the user
                $type = 'success';
                $text = "Utilisateur supprimé";
                $this->redirect("/admin/users");
            } else {
                $type = 'error';
                $text = "Une erreur s'est produite lors de la suppression de l'utilisateur.";
                if ($user->getRole() === "ADMIN") {
                    $this->redirect("/admin/users");
                } else {
                    $type = 'error';
                    $text = "Vous n'êtes pas admin";
                    $this->redirect("/");
                }
            }
        } else {
            $type = 'error';
            $text = "Une erreur s'est produite.";
            $this->redirect("/");
        }
        $this->notify($text, $type);
    }
}
