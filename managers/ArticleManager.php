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

        $mm = new MediaManager();
        $media = $mm->findOne($result["image_id"]);
        $newMedia = new Media($media->getUrl(), $media->getAlt());

        $cm = new CategoryManager();
        $category = $cm->findOne($result["category_id"]);

        $media = new Article($result["name"], $result["price"],$result["stock"], $category, $newMedia, $result["description"], $result["price"] );
        $media->setId($result["id"]);
        return $media;
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
            $newMedia = new Media($media->getUrl(), $media->getAlt());
    
            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $media = new Article($item["name"], $item["price"],$item["stock"], $category, $newMedia, $item["description"], $item["price"] );
            $media->setId($item["id"]);
            $medias[]= $media;
        }
        return $medias;
    }
}