<?php

class PageController extends AbstractController
{
    public function articles() : void
    {   
        $am = new ArticleManager();

        $articles = $am->findAll();
        
        $this->render("pages/articles.html.twig", [
            "articles"=>$articles,
        ]);
    }
    
    public function article(int $id) : void
    {
        $success = isset($_SESSION["success-message"]) ? $_SESSION["success-message"] : null;
        unset($_SESSION["success-message"]);
        
        $error = isset($_SESSION["error-message"]) ? $_SESSION["error-message"] : null;
        unset($_SESSION["error-message"]);

        $am = new ArticleManager();
        $cm = new CommentManager();

        $article = $am->findOne(intval($id));
        $comments = $cm->findAllById($article->getId());

        // Calculer la moyenne des notes
        $totalGrade = 0;
        $numberOfComments = count($comments);
        foreach ($comments as $comment) {
            $totalGrade += $comment->getGrade();
        }
        
        $averageGrade = $numberOfComments > 0 ? $totalGrade / $numberOfComments : 0;
        $averageGrade = ceil($averageGrade);

        $this->render("pages/article.html.twig", [
            "article"=>$article,
            "comments"=> $comments,
            "success" => $success,
            "error" => $error,
            "averageGrade" => $averageGrade
        ]);
    }

    public function dogFood() : void
    {
        $am = new ArticleManager();

        $articles = $am->dogFood();

        $this->render("pages/dog-food.html.twig", [
            "articles"=>$articles,
        ]);
    }
    public function toys() : void
    {
        $am = new ArticleManager();

        $articles = $am->toys();

        $this->render("pages/toys.html.twig", [
            "articles"=>$articles,
        ]);
    }
    public function treats() : void
    {   
        $am = new ArticleManager();

        $articles = $am->treats();

        $this->render("pages/treats.html.twig", [
            "articles"=>$articles,

        ]);
    }

    public function search() : void
    {
        if(isset($_POST['search'])) { 
            $search = htmlspecialchars($_POST['search']);
    
            $am = new ArticleManager();
            $articles = $am->searchArticles($search);
            
            $this->render("pages/articles-search.html.twig", [
                "articles"=>$articles
            ]);
        } else {
            $this->redirect("index.php");
        }
    }

    public function contact() : void
    {
        $this->render("pages/contact.html.twig", [
        ]);
    }
    public function conditions() : void
    {
        $this->render("pages/conditions.html.twig", [
        ]);
    }
    public function legal() : void
    {
        $this->render("pages/legal.html.twig", [
        ]);
    }
    public function privacy() : void
    {
        $this->render("pages/privacy.html.twig", [
        ]);
    }
    public function refund() : void
    {
        $this->render("pages/refund.html.twig", [
        ]);
    }
}