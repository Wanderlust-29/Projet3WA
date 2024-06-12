<?php

class MediaManager extends AbstractManager
{
    /**
     * Récupère un média en fonction de son identifiant.
     *
     * @param int $id L'identifiant du média à récupérer.
     * @return Media|null L'objet média trouvé ou null s'il n'existe pas.
     */
    public function findOne(int $id): ?Media
    {
        $query = $this->db->prepare('SELECT * FROM media WHERE id=:id');
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $media = new Media($result["url"], $result["alt"]);
            $media->setId($result["id"]);
            return $media;
        }
        return null;
    }

    /**
     * Récupère tous les médias.
     *
     * @return array Liste des médias.
     */
    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM media');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $medias = [];

        foreach ($result as $item) {
            $media = new Media($item["url"], $item["alt"]);
            $media->setId($item["id"]);
            $medias[] = $media;
        }
        return $medias;
    }

    /**
     * Insère un média dans la base de données.
     *
     * @param Media $media Le média à insérer.
     * @return Media $media
     */
    public function insert(Media $media): ?Media
    {
        $query = $this->db->prepare('INSERT INTO media (url, alt) VALUES (:url, :alt)');
        $parameters = [
            'url' => $media->getUrl(),
            'alt' => $media->getAlt()
        ];
        $query->execute($parameters);
        $media->setId($this->db->lastInsertId());

        return $media;
    }

    /**
     * Supprime un média.
     *
     * @param Media $media Le média à insérer.
     * @return void
     */
    public function delete(Media $media): bool
    {
        $query = $this->db->prepare('DELETE FROM media WHERE id=:id');
        $parameters = [
            'id' => $media->getId(),
        ];
        $query->execute($parameters);
        if ($query->rowCount() === 0) {
            return false;
        } else {
            $url = $media->getUrl();
            if (!str_starts_with($url, 'http')) {
                unlink(__DIR__ . '/../' . $url);
            }
            return true;
        }
    }
}
