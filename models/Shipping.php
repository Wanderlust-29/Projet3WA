<?php

class Shipping
{
    private ?int $id = null;

    public function __construct(private string $name, private string $description, private float $price, private int $delivery_min = 1, private int $delivery_max = 1)
    {
    }

    // Transform object Shipping to array
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'delivery_min' => $this->delivery_min,
            'delivery_max' => $this->delivery_max
        ];
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

    // Getter and Setter for name
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    // Getter and Setter for description
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    // Getter and Setter for price
    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    // Getter and Setter for delivery min
    /**
     * @return int
     */
    public function getDeliveryMin(): int
    {
        return $this->delivery_min;
    }

    /**
     * @param int $delivery min 
     */
    public function setDeliveryMin(int $delivery_min): void
    {
        $this->delivery_min = $delivery_min;
    }


    // Getter and Setter for delivery max
    /**
     * @return int
     */
    public function getDeliveryMax(): int
    {
        return $this->delivery_max;
    }

    /**
     * @param int $delivery miax
     */
    public function setDeliveryMax(int $delivery_max): void
    {
        $this->delivery_max = $delivery_max;
    }
}
