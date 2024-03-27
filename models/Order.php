<?php

class Order
{
    private ? int $id = null;
    
    
    public function __construct(private User $userId, private string $createdAt, private string $status = "en cours")
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

    // Getter and Setter for User
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
}