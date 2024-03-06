<?php

class MediaManager extends AbstractManager
{
    public function findOne(int $id) : ?Media
    {
        $query = $this->db->prepare('SELECT * FROM media
                                    WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if($result)
        {
            $media = new Media($result["url"], $result["alt"]);
            $media->setId($result["id"]);
            return $media;
        }
        return null;
    }
    
    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM media');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $medias = [];
        
        foreach($result as $item){
            $media = new Media($item["url"], $item["alt"]);
            $media->setId($item["id"]);
            $medias[]= $media;
        }
        return $medias;
    }

    public function insert(Media $media): void 
    {
        $query = $this->db->prepare('INSERT INTO media (url, alt) VALUES (:url, :alt)');
        $parameters = [
            'url' => $media->getUrl(),
            'alt' => $media->getAlt()
        ];
        $query->execute($parameters);
    }
}