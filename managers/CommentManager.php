<?php

class CommentManager extends AbstractManager
{
    /**
     * Récupère les commentaires en fonction de l'id de l'article.
     *
     * @param int id L'identifiant des commentaires à récupérer.
     * @return Comment[] un tableau.
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
            $comment = new Comment($article, $item["grade"], $item["comment"]);
            $comments[] = $comment;
        }
        return $comments;
    }
}