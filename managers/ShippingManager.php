<?php

class ShippingManager extends AbstractManager
{
    /**
     * Fetches a shipping method based on its identifier.
     *
     * @param int $id The identifier of the shipping method to fetch.
     * @return Shipping|null The found shipping method object or null if it doesn't exist.
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
     * Fetches a shipping method based on its name.
     *
     * @param string $name The name of the shipping method to fetch.
     * @return Shipping|null The found shipping method object or null if it doesn't exist.
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
     * Fetches all shipping methods.
     *
     * @return array List of shipping method objects.
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
     * Inserts a new shipping method into the database.
     *
     * @param Shipping $shipping The new shipping method to insert.
     * @return int The ID of the newly inserted shipping method.
     */
    public function insert(Shipping $shipping): int
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
        return $this->db->lastInsertId();
    }

    /**
     * Updates a shipping method in the database.
     *
     * @param Shipping $shipping The shipping method to update.
     * @return bool True if the update was successful, false otherwise.
     * @throws Exception If the shipping method doesn't exist.
     */
    public function update(Shipping $shipping): bool
    {
        $query = $this->db->prepare('UPDATE shipping SET name=:name,description=:description,delivery_min=:delivery_min, delivery_max=:delivery_max, price=:price WHERE id = :id');

        $parameters = [
            "id" => $shipping->getId(),
            "name" => $shipping->getName(),
            "description" => $shipping->getDescription(),
            "delivery_min" => $shipping->getDeliveryMin(),
            "delivery_max" => $shipping->getDeliveryMax(),
            "price" => $shipping->getPrice(),
        ];

        $result = $query->execute($parameters);
        return $result;
    }

    /**
     * Deletes a shipping method from the database.
     *
     * @param Shipping $shipping The shipping method to delete.
     * @return void
     * @throws Exception If the shipping method doesn't exist.
     */
    public function delete(Shipping $shipping): void
    {
        $query = $this->db->prepare('DELETE FROM articles 
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
