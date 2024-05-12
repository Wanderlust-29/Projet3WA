<?php

class OrderArticle

{
    public function __construct(private Order $orderId, private Article $articleId)
    {

    }
    // Getter and Setter for Order
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
    public function setOrderId(Order $orderId): void
    {
        $this->orderId = $orderId;
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
}