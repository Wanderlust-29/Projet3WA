<?php

class Order
{
    private ? int $id = null;
    private ? array $user = [];
    private ? array $articles = [];
    
    public function __construct(private int $userId, private string $createdAt, private string $status, private Shipping $shipping, private float $totalPrice)
    {
        $this->status = !empty($status) ? $status : "pending";
    }

    // Transform object Order to array
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->userId,
            'createdAt' => $this->createdAt,
            'shipping' => $this->shipping,
            'status' => $this->status,
            'totalPrice' => $this->totalPrice,
        ];
    }

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

    // Getter and Setter for $userId
    /**
     * @return int 
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    // Getter and Setter for createdAt
    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    // Getter and Setter for status
    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    // Getter and Setter for shipping
    /**
     * @return Shipping
     */
    public function getShipping(): Shipping
    {
        return $this->shipping;
    }

    /**
     * @param array $shipping
     */
    public function setShipping(Shipping $shipping): void
    {
        $this->shipping = $shipping;
    }

    // Getter and Setter for totalPrice
    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }

    /**
     * @param float $total_price
     */
    public function setTotalPrice(float $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    // Getter and Setter for User
    /**
     * @return array
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * @param array $user
     */
    public function setUser(array $user): void
    {
        $this->user = $user;
    }



    // Getter and Setter for Articles
    /**
     * @return array
     */
    public function getArticles(): array
    {
        return $this->articles;
    }

    /**
     * @param array $articles
     */
    public function setArticles(array $articles): void
    {
        $this->articles = $articles;
    }
    

}