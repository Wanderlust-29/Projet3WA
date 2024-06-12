<?php

use Cocur\Slugify\Slugify;

class ArticleManager extends AbstractManager
{
    /**
     * Retrieves an article based on its ID.
     *
     * @param int $id The ID of the article to retrieve.
     * @return Article|null The found article object or null if it doesn't exist.
     */
    public function findOne(int $id): ?Article
    {
        $query = $this->db->prepare('SELECT * FROM articles WHERE id=:id');
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $mm = new MediaManager();
            $media = $mm->findOne($result["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($result["category_id"]);

            $article = new Article($result["name"], $result["price"], $result["stock"], $category, $media, $result["description"], $result["ingredients"], $result["age"], $result["short_description"], $result["slug"]);
            $article->setId($result["id"]);
            return $article;
        }

        return null;
    }

    /**
     * Retrieves an article based on its slug.
     *
     * @param string $slug The slug of the article to retrieve.
     * @return Article|null The found article object or null if it doesn't exist.
     */
    public function findBySlug(string $slug): ?Article
    {
        $query = $this->db->prepare('SELECT * FROM articles WHERE slug=:slug');
        $parameters = ["slug" => $slug];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $mm = new MediaManager();
            $media = $mm->findOne($result["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($result["category_id"]);

            $article = new Article($result["name"], $result["price"], $result["stock"], $category, $media, $result["description"], $result["ingredients"], $result["age"], $result["short_description"], $result["slug"]);
            $article->setId($result["id"]);
            return $article;
        }

        return null;
    }

    /**
     * Retrieves all articles.
     *
     * @return array List of articles.
     */
    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM articles');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * Retrieves the top 9 articles based on sales count.
     *
     * @return array List of the top 9 articles.
     */
    public function TopNine(): array
    {
        $query = $this->db->prepare('SELECT articles.*, COUNT(orders_articles.article_id) AS total_sales
                                    FROM articles
                                    JOIN orders_articles ON articles.id = orders_articles.article_id
                                    GROUP BY articles.id
                                    ORDER BY total_sales DESC LIMIT 9;');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * Retrieves articles of a specific category.
     *
     * @param int $category_id The ID of the category.
     * @return array List of articles in the specified category.
     */
    public function findByCat(int $category_id): array
    {
        $query = $this->db->prepare('SELECT * FROM articles WHERE category_id =:category_id');
        $parameters = [
            "category_id" => $category_id
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }


    /**
     * Updates the stock of an article.
     *
     * @param Article $article The article object whose stock to update.
     * @return bool True if stock update successful, false otherwise.
     */
    public function update(Article $article): bool
    {
        $query = $this->db->prepare(
            '
            UPDATE articles 
            SET 
            name = :name,
            price = :price,
            category_id = :category_id,
            image_id = :image_id,
            description = :description,
            ingredients = :ingredients,
            age = :age,
            short_description = :short_description,
            slug = :slug
            WHERE id = :id'
        );

        $parameters = [
            "id" => $article->getId(),
            "name" => $article->getName(),
            "price" => $article->getPrice(),
            "category_id" => $article->getCategory()->getId(),
            "image_id" => $article->getImage()->getId(),
            "description" => $article->getDescription(),
            "ingredients" => $article->getIngredients(),
            "age" => $article->getAge(),
            "short_description" => $article->getShortDescription(),
            "slug" => $article->getSlug(),
        ];

        $query->execute($parameters);

        if ($query->rowCount() === 0) {
            // throw new Exception("Article with ID " . $article->getId() . " not found.");
            return false;
        } else {
            return true;
        }
    }

    /**
     * Updates the stock of an article.
     *
     * @param Article $article The article object whose stock to update.
     * @return bool True if stock update successful, false otherwise.
     */
    public function updateStock(Article $article): bool
    {
        $query = $this->db->prepare('UPDATE articles 
        SET stock = :stock
        WHERE id = :id');

        $parameters = [
            "id" => $article->getId(),
            "stock" => $article->getStock()
        ];
        $query->execute($parameters);

        if ($query->rowCount() === 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Updates the image of an article.
     *
     * @param Article $article The article object to update.
     * @param Media $media The new media object for the article's image.
     * @return bool True if image update successful, false otherwise.
     */
    public function updateImage(Article $article, Media $media): bool
    {
        $old_media = $article->getImage();

        $query = $this->db->prepare('UPDATE articles 
        SET image_id = :image_id
        WHERE id = :id');

        $parameters = [
            "id" => $article->getId(),
            "image_id" => $media->getId()
        ];
        $query->execute($parameters);

        if ($query->rowCount() === 0) {
            return false;
        } else {
            $om = new MediaManager();
            $om->delete($old_media);
            return true;
        }
    }

    /**
     * Inserts a new article into the database.
     *
     * @param Article $article The new article object to insert.
     * @return int The ID of the inserted article.
     */
    public function insert(Article $article): int
    {

        $query = $this->db->prepare('INSERT INTO articles (name, price, stock, category_id, image_id, description, ingredients, age, short_description, slug) VALUES (:name, :price, :stock, :category_id, :image_id, :description, :ingredients, :age, :short_description, :slug)');

        $parameters = [
            "name" => $article->getName(),
            "price" => $article->getPrice(),
            "stock" => $article->getStock(),
            "category_id" => $article->getCategory()->getId(),
            "image_id" => $article->getImage()->getId(),
            "description" => $article->getDescription(),
            "ingredients" => $article->getIngredients(),
            "age" => $article->getAge(),
            "short_description" => $article->getShortDescription(),
            "slug" => $article->getSlug()
        ];

        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    /**
     * Searches articles based on a search query.
     *
     * @param string $search The search query.
     * @return array List of articles matching the search query.
     */
    public function searchArticles($search): array
    {
        $query = $this->db->prepare('SELECT * FROM articles WHERE name LIKE :search OR description LIKE :search OR ingredients LIKE :search');
        $parameters = [
            ':search' => "%$search%"
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];

        foreach ($result as $item) {
            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);

            $articles[] = $article;
        }

        return $articles;
    }

    /**
     * Deletes an article from the database.
     *
     * @param Article $article The article object to delete.
     * @return void
     * @throws Exception If the article doesn't exist.
     */
    public function delete(Article $article): void
    {
        $query = $this->db->prepare('DELETE articles 
        WHERE id = :id');

        $parameters = [
            "id" => $article->getId()
        ];
        $query->execute($parameters);
        // Vérifier si l'article a été trouvé et supprimé
        if ($query->rowCount() === 0) {
            throw new Exception("Article with ID " . $article->getId() . " not found.");
        }
    }

    /**
     * Sorts articles by popularity (total sales).
     *
     * @return array List of articles sorted by popularity.
     */
    public function sortByPopularity(): array
    {
        $query = $this->db->prepare('SELECT articles.*, COUNT(orders_articles.article_id) AS total_sales
                                    FROM articles
                                    JOIN orders_articles ON articles.id = orders_articles.article_id
                                    GROUP BY articles.id
                                    ORDER BY total_sales DESC');

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * Sorts articles by price in ascending order.
     *
     * @return array List of articles sorted by price ascending.
     */
    public function sortByAsc(): array
    {
        $query = $this->db->prepare('SELECT * FROM `articles` ORDER BY `articles`.`price` ASC');

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * Sorts articles by price in descending order.
     *
     * @return array List of articles sorted by price descending.
     */
    public function sortByDesc(): array
    {
        $query = $this->db->prepare('SELECT * FROM `articles` ORDER BY `articles`.`price` DESC');

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * Sorts articles of a specific category by popularity (total sales).
     *
     * @param Category $categoryId The category object.
     * @return array List of articles in the category sorted by popularity.
     */
    public function sortByPopularityCat(Category $categoryId): array
    {
        $query = $this->db->prepare('SELECT articles.*, COUNT(orders_articles.article_id) AS total_sales
                                    FROM articles
                                    JOIN orders_articles ON articles.id = orders_articles.article_id
                                    WHERE articles.category_id = :category_id
                                    GROUP BY articles.id
                                    ORDER BY total_sales DESC');
        $parameters = [
            ':category_id' => $categoryId->getId()
        ];

        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {
            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $categoryId, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }

        return $articles;
    }

    /**
     * Sorts articles of a specific category by price in ascending order.
     *
     * @param Category $categoryId The category object.
     * @return array List of articles in the category sorted by price ascending.
     */
    public function sortByAscCat(Category $categoryId): array
    {
        $query = $this->db->prepare('SELECT * FROM articles WHERE category_id = :category_id ORDER BY price ASC');
        $parameters = [
            ':category_id' => $categoryId->getId()
        ];

        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {
            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $categoryId, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }

        return $articles;
    }

    /**
     * Sorts articles of a specific category by price in descending order.
     *
     * @param Category $categoryId The category object.
     * @return array List of articles in the category sorted by price descending.
     */
    public function sortByDescCat(Category $categoryId): array
    {
        $query = $this->db->prepare('SELECT * FROM articles WHERE category_id = :category_id ORDER BY price DESC');
        $parameters = [
            ':category_id' => $categoryId->getId()
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];

        foreach ($result as $item) {
            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $article = new Article($item["name"], $item["price"], $item["stock"], $categoryId, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }

        return $articles;
    }
}
