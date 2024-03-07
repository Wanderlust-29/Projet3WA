<?php

class CategoryManager extends AbstractManager
{
    /**
     * Récupère une catégorie en fonction de son identifiant.
     *
     * @param int $id L'identifiant de la catégorie à récupérer.
     * @return Category|null L'objet catégorie trouvé ou null s'il n'existe pas.
     */
    public function findOne(int $id) : ?Category
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $category = new Category($result["name"], $result["description"]);
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
        $query = $this->db->prepare('SELECT * FROM categories');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $categories=[];

        foreach($result as $item){
            $category = new Category($item["name"], $item["description"]);
            $category->setId($item["id"]);
            $categories[]=$category;
        }
        return $categories;
    }
}
