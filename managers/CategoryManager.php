<?php

class CategoryManager extends AbstractManager
{
    /**
     * Récupère une catégorie en fonction de son identifiant.
     *
     * @param int $id L'identifiant de la catégorie à récupérer.
     * @return Category|null L'objet catégorie trouvé ou null s'il n'existe pas.
     */
    public function findOne(int $id) : Category
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $category = new Category($result["name"], $result["description"], $result["slug"]);
            $category->setId($result["id"]);
            return $category;
        }
        return null;
    }

        /**
     * Récupère une catégorie en fonction de son identifiant.
     *
     * @param string $slug Le slug de la catégorie à récupérer.
     * @return Category|null L'objet catégorie trouvé ou null s'il n'existe pas.
     */
    public function findOneBySlug(string $slug) : ?Category
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE slug=:slug');
        $parameters = [
            "slug" => $slug
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $category = new Category($result["name"], $result["description"], $result["slug"]);
            $category->setId($result["id"]);
            return $category;
        }
        return null;
    }

    /**
     * Récupère toutes les catégories.
     *
     * @return array Liste des catégories.
    */
    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT c.*, COUNT(a.id) AS total_products FROM categories as c LEFT JOIN articles AS a ON c.id = a.category_id GROUP BY c.id');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $categories=[];

        foreach($result as $item){
            $category = new Category($item["name"], $item["description"],  $item["slug"]);
            $category->setId($item["id"]);
            $cat =$category->toArray();
            $cat['total_products'] = $item["total_products"];
            $categories[] = $cat;
        }
        return $categories;
    }

    /**
     * Mise à jour d'une catégorie.
     *
     * @param Category $category l'objet catégorie
     * @return bool résultat de la mise à jour en bdd
    */
    public function update(Category $category) : bool
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
     * Création d'une catégorie.
     *
     * @param Category $category l'objet catégorie
     * @return bool résultat de la mise à jour en bdd
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
