<?php

class CommentController extends AbstractController
{
    public function newComment($articleId) : void
    {
        $am = new ArticleManager();

        $article = $am->findOne(intval($articleId));

        $this->render("account/comment.html.twig", [
            "article" => $article,
        ]);
    }

    public function checkComment($articleId) : void
    {
        
        if (isset($_POST["grade"]) && isset($_POST["comment"])) 
        {

            if (isset($_SESSION['user'])) {
                // L'objet $user avec les informations de l'utilisateur connecté
                $userId = $_SESSION['user']->getId();

                $userManager = new UserManager();
                $user = $userManager->findOne(($userId));

                $cm = new CommentManager();

                $am = new ArticleManager();
                $article = $am->findOne(intval($articleId));

                // Crée un nouveau commentaire
                $grade = $_POST["grade"];
                $commentText = htmlspecialchars($_POST["comment"]);
                $comment = new Comment($article, $user, $grade, $commentText);
                $cm->create($comment);
                $this->redirect("index.php?route=account");
            } else {
                // Redirection si l'utilisateur n'est pas connecté
                $_SESSION["error-message"] = "Vous devez être connecté pour commenter.";
                $this->redirect("index.php");
            }
        } else {
            // Redirection si les données de commentaire ne sont pas complètes
            $_SESSION["error-message"] = "Veuillez remplir tous les champs du commentaire.";
            $this->redirect("index.php");
        }
    }

}