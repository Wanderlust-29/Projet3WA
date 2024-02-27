<?php
class Article
{
    private ?int $id = null;

    public function __construct(private string $name, private float $price, private int $stock, private Category $category, private Media $image, private string $description, private string $size)
    {
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
        $this->image = $image;
        $this->description = $description;
        $this->size = $size;
    }

    // Getter and Setter for ID
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

    // Getter and Setter for Name
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

    // Getter and Setter for Price
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
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    // Getter and Setter for Stock
    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param string $stock
     */
    public function setStock(string $stock): void
    {
        $this->stock = $stock;
    }

    // Getter and Setter for Password
    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setPassword(Category $category): void
    {
        $this->category = $category;
    }

    // Getter and Setter for Image
    /**
     * @return Media
     */
    public function getImage(): Media
    {
        return $this->image;
    }

    /**
     * @param Media $image
     */
    public function setImage(Media $image): void
    {
        $this->image = $image;
    }

    // Getter and Setter for Description
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

    // Getter and Setter for Size
    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

    // Getter and Setter for Country
    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    // Getter and Setter for Role
    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}
