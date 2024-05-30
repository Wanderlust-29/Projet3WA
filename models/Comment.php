<?php

class Comment
{
    private ? int $id = null;
    
    public function __construct(private Article $articleId, private User $userId, private int $grade, private string $comment, private string $status = "pending")
    {

    }

    // Getter and Setter for id
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    // Getter and Setter for Article
    /**
     * @return Article
     */
    public function getArticleId(): Article
    {
        return $this->articleId;
    }

    /**
     * @param Article $articleId
     */
    public function setArticleId(Article $articleId): void
    {
        $this->articleId = $articleId;
    }

    // Getter and Setter for Article
    /**
     * @return User
     */
    public function getUserId(): User
    {
        return $this->userId;
    }

    /**
     * @param User $userId
     */
    public function setUserId(User $userId): void
    {
        $this->userId = $userId;
    }

    // Getter and Setter for grade
    /**
     * @return int
     */
    public function getGrade(): ?int
    {
        return $this->grade;
    }
    /**
     * @param int|null $grade
     */
    public function setGrade (?int $grade): void
    {
        $this->grade = $grade;
    }

    // Getter and Setter for comment
    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }
    /**
     * @param string|null $comment
     */
    public function setComment (?string $comment): void
    {
        $this->comment = $comment;
    }

    // Getter and Setter for status
    /**
     * @return string
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }
    /**
     * @param string|null $comment
     */
    public function setStatus (?string $status): void
    {
        $this->status = $status;
    }
}