<?php
class Article
{
    private ?int $id = null;

    public function __construct(private string $name, private float $price, private int $stock, private Category $category, private Media $image, private string $description, private string $ingredients, private string $age)
    {

    }

    // Transforme en tableau
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'stock' => $this->stock,
            'category' => $this->category,
            'image' => $this->image,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'age' => $this->age,
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
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    // Getter and Setter for Category
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

    // Getter and Setter for Ingredient
    /**
     * @return string
     */
    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    /**
     * @param string $ingredients
     */
    public function setIngredients(string $ingredients): void
    {
        $this->ingredients = $ingredients;
    }

    // Getter and Setter for Age
    /**
     * @return string
     */
    public function getAge(): string
    {
        return $this->age;
    }

    /**
     * @param string $age
     */
    public function setAge(string $age): void
    {
        $this->age = $age;
    }
}
