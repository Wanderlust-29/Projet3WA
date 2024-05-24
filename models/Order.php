<?php

class Order
{
    private ? int $id = null;
    
    
    public function __construct(private int $userId, private string $createdAt, private string $status, private float $totalPrice)
    {
        $this->status = !empty($status) ? $status : "pending";
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
}