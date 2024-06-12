<?php

class MediaManager extends AbstractManager
{
    /**
     * Fetches a media based on its identifier.
     *
     * @param int $id The identifier of the media to fetch.
     * @return Media|null The found media object or null if it doesn't exist.
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
     * Fetches all media.
     *
     * @return array List of media objects.
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
     * Inserts a media into the database.
     *
     * @param Media $media The media object to insert.
     * @return Media|null The inserted media object with updated ID.
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
     * Deletes a media from the database and optionally deletes the physical file.
     *
     * @param Media $media The media object to delete.
     * @return bool True if deletion was successful, false otherwise.
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
