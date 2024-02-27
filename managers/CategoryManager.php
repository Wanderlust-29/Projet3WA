<?php

class CategoryManager extends AbstractManager
{
    public function findOne(int $id) : ?Category
    {
        $query = $this->db->prepare('SELECT * FROM categories
                                    WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $category = new Category($result["name"], $result["description"]);
        $category->setId($result["id"]);
        return $category;
    }

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