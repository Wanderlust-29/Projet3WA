<?php

class Category
{
    private ? int $id = null;
    
    public function __construct(private string $name, private string $description, private string $slug)
    {

    }

    // Transform object Category to array
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug
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
    
    // Getter and Setter for slug
    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $description
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}