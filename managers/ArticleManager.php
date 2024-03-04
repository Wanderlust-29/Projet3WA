<?php

class ArticleManager extends AbstractManager
{
    public function findOne(int $id) : ?Article
    {
        $query = $this->db->prepare('SELECT * FROM articles
                                    WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $mm = new MediaManager();
            $media = $mm->findOne($result["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($result["category_id"]);

            $media = new Article($result["name"], $result["price"],$result["stock"], $category, $media, $result["description"], $result["age"] );
            $media->setId($result["id"]);
            return $media;
        }

        return null;
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM articles');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $medias = [];
        
        foreach($result as $item){

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);
    
            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $media = new Article($item["name"], $item["price"],$item["stock"], $category, $media, $item["description"], $item["age"] );
            $media->setId($item["id"]);
            $medias[]= $media;
        }
        return $medias;
    }
    
    public function TopFour() : array
    {
        $query = $this->db->prepare('SELECT articles.*, COUNT(orders_articles.article_id) AS total_sales
                                    FROM articles
                                    JOIN orders_articles ON articles.id = orders_articles.article_id
                                    GROUP BY articles.id
                                    ORDER BY total_sales DESC LIMIT 4;');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $medias = [];
        
        foreach($result as $item){

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);
    
            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $media = new Article($item["name"], $item["price"],$item["stock"], $category, $media, $item["description"], $item["age"] );
            $media->setId($item["id"]);
            $medias[]= $media;
        }
        return $medias;
    }
}