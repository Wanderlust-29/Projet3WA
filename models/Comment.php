<?php

class Comment
{
    
    public function __construct(private Article $articleId, private int $grade, private string $comment)
    {

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
}