<?php

class OrderArticle

{
    public function __construct(private Order $orderId, private Article $articleId)
    {

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