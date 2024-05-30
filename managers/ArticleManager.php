<?php
use Cocur\Slugify\Slugify;
class ArticleManager extends AbstractManager
{
    /**
     * Récupère un article en fonction de son identifiant.
     *
     * @param int $id L'identifiant de l'article à récupérer.
     * @return Article|null L'objet article trouvé ou null s'il n'existe pas.
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

            $article = new Article($result["name"], $result["price"], $result["stock"], $category, $media, $result["description"], $result["ingredients"], $result["age"], $result["short_description"],$result["slug"]);
            $article->setId($result["id"]);
            return $article;
        }

        return null;
    }

    /**
     * Récupère un article en fonction de son slug.
     *
     * @param string $slug Le slug de l'article à récupérer.
     * @return Article|null L'objet article trouvé ou null s'il n'existe pas.
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

            $article = new Article($result["name"], $result["price"], $result["stock"], $category, $media, $result["description"], $result["ingredients"], $result["age"], $result["short_description"],$result["slug"]);
            $article->setId($result["id"]);
            return $article;
        }

        return null;
    }

    /**
     * Récupère tous les articles.
     *
     * @return array Liste des articles.
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

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"],$item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * Récupère les 9 meilleurs articles basés sur le nombre de ventes.
     *
     * @return array Liste des 9 meilleurs articles.
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

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"],$item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * Récupère les articles de la categorie Croquettes.
     *
     * @return array Liste des articles de la categorie Croquettes.
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

            $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"],$item["slug"]);
            $article->setId($item["id"]);
            $articles[] = $article;
        }
        return $articles;
    }


    /**
     * Met à jour le stock d'un article.
     *
     * @param Article $article L'article à mettre à jour.
     * @return void
     */
    public function update(Article $article): bool
    {
        $query = $this->db->prepare('
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
        // Vérifier si l'article a été trouvé et mis à jour
        if ($query->rowCount() === 0) {
            // throw new Exception("Article with ID " . $article->getId() . " not found.");
            return false;
        }else{
            return true;
        }
    }

    /**
     * Met à jour le stock d'un article.
     *
     * @param Article $article L'article à mettre à jour.
     * @return void
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
        // Vérifier si l'article a été trouvé et mis à jour
        if ($query->rowCount() === 0) {
            return false;
        }else{
            return true;
        }
    }

        /**
     * Met à jour le stock d'un article.
     *
     * @param Article $article L'article à mettre à jour.
     * @return void
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
        // Vérifier si l'article a été trouvé et mis à jour
        if ($query->rowCount() === 0) {
            return false;
        }else{
            $om = new MediaManager();
            $om->delete($old_media);
            return true;
        }
    }

    /**
     * Insère un nouvel article dans la base de données.
     *
     * @param Article $article Le nouvel article à insérer.
     * @return void
     * 
     */
    public function insert(Article $article): int
    {
        $sql = 
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
     * Supprime un article.
     *
     * @param Article $article L'article à mettre à jour.
     * @return void
     * @throws Exception Si l'article n'existe pas.
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
}
