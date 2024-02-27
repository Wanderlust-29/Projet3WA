<?php

class OrderArticle

{
    private ? int $id = null;
    
    public function __construct(private Order $orderId, private Article $articleId)
    {
        $this->orderId = $orderId;
        $this->articleId = $articleId;
    }

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

    /**
     * @return Order
     */
    public function getOrderId(): Order
    {
        return $this->orderId;
    }

    /**
     * @param Order $orderId
     */
    public function setUserId(Order $orderId): void
    {
        $this->orderId = $orderId;
    }

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
}