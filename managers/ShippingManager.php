<?php

class ShippingManager extends AbstractManager
{
    /**
     * Récupère un frais de port  en fonction de son identifiant.
     *
     * @param int $id L'identifiant du frais de port à récupérer.
     * @return Shipping|null L'objet shipping trouvé ou null s'il n'existe pas.
     */
    public function findOne(int $id): ?Shipping
    {
        $query = $this->db->prepare('SELECT * FROM shipping WHERE id=:id');
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $shipping = new Shipping($result["name"], $result["description"], $result["price"], $result["delivery_min"], $result["delivery_max"]);
            $shipping->setId($result["id"]);
            return $shipping;
        }

        return null;
    }

    /**
     * Récupère un frais de port en fonction de son nom.
     *
     * @param string $name Le nom du frais de port à récupérer.
     * @return Shipping|null L'objet shipping trouvé ou null s'il n'existe pas.
     */
    public function findByName(string $name): ?Shipping
    {
        $query = $this->db->prepare('SELECT * FROM shipping WHERE name=:name');
        $parameters = ["name" => $name];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $shipping = new Shipping($result["name"], $result["description"], $result["price"], $result["delivery_min"], $result["delivery_max"]);
            $shipping->setId($result["id"]);
            return $shipping;
        }

        return null;
    }

    /**
     * Récupère tous les frais de port.
     *
     * @return array Liste des frais de port.
     */
    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM shipping');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $shippings = [];

        foreach ($result as $item) {
            $shipping = new Shipping($item["name"], $item["description"], $item["price"], $item["delivery_min"], $item["delivery_max"]);
            $shipping->setId($item["id"]);
            $shippings[] = $shipping;
        }
        return $shippings;
    }

    /**
     * Insère un nouvel frais de port dans la base de données.
     *
     * @param Shipping $shipping Le nouveau frais de port à insérer.
     * @return void
     * 
     */
    public function insert(Shipping $shipping): void
    {
        $query = $this->db->prepare('INSERT INTO shipping (name, description, price, delivery_min, delivery_max) VALUES (:name, :description, :price, :delivery_min, :delivery_max)');

        $parameters = [
            "name" => $shipping->getName(),
            "description" => $shipping->getDescription(),
            "price" => $shipping->getPrice(),
            "delivery_min" => $shipping->getDeliveryMin(),
            "delivery_max" => $shipping->getDeliveryMax(),
        ];

        $query->execute($parameters);
        $shipping->setId($this->db->lastInsertId());
    }

    /**
     * Supprime un frais de port.
     *
     * @param Shipping $shipping Le frais de port à supprimer.
     * @return void
     * @throws Exception Si le frais de port n'existe pas.
     */
    public function delete(Shipping $shipping): void
    {
        $query = $this->db->prepare('DELETE articles 
        WHERE id = :id');

        $parameters = [
            "id" => $shipping->getId()
        ];
        $query->execute($parameters);
        // Vérifier si l'article a été trouvé et supprimé
        if ($query->rowCount() === 0) {
            throw new Exception("Article with ID " . $shipping->getId() . " not found.");
        }
    }
}
