<?php

class CommentManager extends AbstractManager
{

    /**
     * Fetches all comments.
     *
     * @return Comment[] An array containing the comments.
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
     * Fetches all pending comments.
     *
     * @return Comment[] An array containing the comments.
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
     * Fetches comments based on article ID.
     *
     * @param int $articleId The article ID for which to fetch comments.
     * @return Comment[] An array containing the comments.
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
            $comment = new Comment($article, $user, $item["grade"], $item["comment"], $item["status"]);
            $comments[] = $comment;
        }
        return $comments;
    }

    /**
     * Creates a new comment in the database.
     *
     * @param Comment $comment The comment to create.
     * @return void
     */
    public function create(Comment $comment): void
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
     * Updates the status of a comment in the database.
     *
     * @param int $id The ID of the comment to update.
     * @param string $status The new status value.
     * @return bool
     */
    public function updateStatus(int $id, string $status): bool
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
     * Deletes a comment from the database.
     *
     * @param int $id The ID of the comment to delete.
     * @return bool
     */
    public function delete(int $id): bool
    {
        $query = $this->db->prepare('DELETE FROM comments WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $result = $query->execute($parameters);
        return $result;
    }

    /**
     * Retrieves the total number of pending comments.
     *
     * @return int Total number of pending comments.
     */
    public function getPendingCommentsTotal(): int
    {
        $query = $this->db->prepare('SELECT SUM(id) AS total FROM comments WHERE status = "pending" GROUP BY id');
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['total'];
        } else {
            return 0;
        }
    }
}
