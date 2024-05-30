<?php

class CommentManager extends AbstractManager
{

    /**
     * Récupère tous les commentaires.
     *
     * 
     * @return Comment[] Un tableau contenant les commentaires.
     */
    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM comments');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $comments = [];
    
        foreach ($result as $item) {

            $am = new ArticleManager();
            $article = $am->findOne($item['article_id']);

            $um = new UserManager();
            $user = $um->findOne($item["user_id"]);

            $comment = new Comment($article, $user, $item["grade"], $item["comment"], $item["status"]);
            $comment->setId($item["id"]);
            $comments[] = $comment;
        }
        return $comments;
    }

    /**
     * Récupère tous les commentaires en attente
     *
     * 
     * @return Comment[] Un tableau contenant les commentaires.
     */
    public function findAllPending(): array
    {
        $query = $this->db->prepare('SELECT * FROM comments WHERE status = "pending"');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $comments = [];
    
        foreach ($result as $item) {

            $am = new ArticleManager();
            $article = $am->findOne($item['article_id']);

            $um = new UserManager();
            $user = $um->findOne($item["user_id"]);

            $comment = new Comment($article, $user, $item["grade"], $item["comment"], $item["status"]);
            $comment->setId($item["id"]);
            $comments[] = $comment;
        }
        return $comments;
    }

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
            $comment = new Comment($article, $user, $item["grade"], $item["comment"],$item["status"]);
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
        $query = $this->db->prepare('INSERT INTO comments (article_id, user_id, grade, comment, status) VALUES (:article_id, :user_id, :grade, :comment, :status)');
        $parameters = [
            "article_id" => $comment->getArticleId()->getId(),
            "user_id" => $comment->getUserId()->getId(),
            "grade" => $comment->getGrade(),
            "comment" => $comment->getComment(),
            "status" => $comment->getStatus(),
        ];

        $query->execute($parameters);
        $comment->setId($this->db->lastInsertId());
    }


    /**
     * Mets à jour un commentaire dans la base de données.
     *
     * @param int $comment Le commentaire à créer.
     * @return bool
     */
    public function updateStatus(int $id, string $status) : bool
    {
        $query = $this->db->prepare('UPDATE comments SET status=:status WHERE id=:id');
        $parameters = [
            "id" => $id,
            "status" => $status,
        ];
        $result = $query->execute($parameters);
        return $result;
    }


    /**
     * Supprime un commentaire dans la base de données.
     *
     * @param Comment $comment Le commentaire à créer.
     * @return bool
     */
    public function delete(int $id) : bool
    {
        $query = $this->db->prepare('DELETE FROM comments WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $result = $query->execute($parameters);
        return $result;
    }

    /**
     * Retourne le nombre de commentaires en attente
     *
     * @return int total commentaires en attente
     */
    public function getPendingCommentsTotal() : int
    {
        $query = $this->db->prepare('SELECT SUM(id) AS total FROM comments WHERE status = "pending" GROUP BY id');
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($result){
            return $result['total'];
        }else{
            return 0;
        }
    }
}