<?php

class CommentManager extends AbstractManager
{
    /**
     * Récupère les commentaires en fonction de l'ID de l'article.
     *
     * @param int $articleId L'identifiant de l'article pour lequel récupérer les commentaires.
     * @return Comment[] Un tableau contenant les commentaires.
     */
    public function findAllById(int $articleId): array
    {
        $query = $this->db->prepare('SELECT * FROM comments WHERE article_id = :article_id');
        $query->execute(['article_id' => $articleId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $comments = [];

        $am = new ArticleManager();
        $article = $am->findOne($articleId);
    
        foreach ($result as $item) {

            $um = new UserManager();
            $user = $um->findOne($item["user_id"]);
            $comment = new Comment($article, $user, $item["grade"], $item["comment"]);
            $comments[] = $comment;
        }
        return $comments;
    }

    /**
     * Crée un nouveau commentaire dans la base de données.
     *
     * @param Comment $comment Le commentaire à créer.
     * @return void
     */
    public function create(Comment $comment) : void
    {
        $query = $this->db->prepare('INSERT INTO comments (article_id, user_id, grade, comment) VALUES (:article_id, :user_id, :grade, :comment)');
        $parameters = [
            "article_id" => $comment->getArticleId()->getId(),
            "user_id" => $comment->getUserId()->getId(),
            "grade" => $comment->getGrade(),
            "comment" => $comment->getComment(),
        ];

        $query->execute($parameters);
        $comment->setId($this->db->lastInsertId());
    }
}