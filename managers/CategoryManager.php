<?php

class CategoryManager extends AbstractManager
{
    /**
     * Fetches a category based on its identifier.
     *
     * @param int $id The identifier of the category to fetch.
     * @return Category|null The found category object or null if it doesn't exist.
     */
    public function findOne(int $id): Category
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $category = new Category($result["name"], $result["description"], $result["slug"]);
            $category->setId($result["id"]);
            return $category;
        }
        return null;
    }

    /**
     * Fetches a category based on its slug.
     *
     * @param string $slug The slug of the category to fetch.
     * @return Category|null The found category object or null if it doesn't exist.
     */
    public function findOneBySlug(string $slug): ?Category
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE slug=:slug');
        $parameters = [
            "slug" => $slug
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $category = new Category($result["name"], $result["description"], $result["slug"]);
            $category->setId($result["id"]);
            return $category;
        }
        return null;
    }

    /**
     * Fetches all categories.
     *
     * @return array List of categories.
     */
    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT c.*, COUNT(a.id) AS total_products FROM categories as c LEFT JOIN articles AS a ON c.id = a.category_id GROUP BY c.id');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];

        foreach ($result as $item) {
            $category = new Category($item["name"], $item["description"],  $item["slug"]);
            $category->setId($item["id"]);
            $cat = $category->toArray();
            $cat['total_products'] = $item["total_products"];
            $categories[] = $cat;
        }
        return $categories;
    }

    /**
     * Updates a category.
     *
     * @param Category $category The category object to update.
     * @return bool Result of the database update operation.
     */
    public function update(Category $category): bool
    {
        $query = $this->db->prepare(
            'UPDATE categories SET name=:name, description=:description WHERE id=:id'
        );

        $param = [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'description' => $category->getDescription(),
        ];
        $result = $query->execute($param);
        return $result;
    }

    /**
     * Creates a category.
     *
     * @param Category $category The category object to insert.
     * @return int The ID of the newly inserted category.
     */
    public function insert(Category $category)
    {
        $query = $this->db->prepare(
            'INSERT INTO categories (name, description, slug) VALUES (:name,:description,:slug)'
        );
        $param = [
            'name' => $category->getName(),
            'description' => $category->getDescription(),
            'slug' => $category->getSlug()
        ];
        $query->execute($param);
        return $this->db->lastInsertId();
    }
}
