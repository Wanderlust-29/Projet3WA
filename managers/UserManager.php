<?php

class UserManager extends AbstractManager
{
    /**
     * Trouve un utilisateur par son identifiant.
     *
     * @param int $id L'identifiant de l'utilisateur à trouver.
     * @return User|null L'objet utilisateur trouvé ou null s'il n'existe pas.
     */
    public function findOne(int $id): ?User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE id=:id');
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["address"], $result["city"], $result["postal_code"], $result["country"], $result["role"]);
            $user->setId($result["id"]);
            return $user;
        }
        return null;
    }

    /**
     * Récupère tous les utilisateurs de la base de données.
     *
     * @return array Liste des utilisateurs.
     */
    public function findAll(): array
    {


        $query = $this->db->prepare('SELECT u.*, COUNT(o.user_id) AS total_orders, SUM(o.total_price) AS total_value FROM users AS u LEFT JOIN orders AS o ON u.id = o.user_id GROUP BY u.id');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($result as $item) {
            $user = new User($item["first_name"], $item["last_name"], $item["email"], $item["password"], $item["address"], $item["city"], $item["postal_code"], $item["country"], $item["role"]);
            $user->setId($item["id"]);
            $user = $user->toArray();
            $user['id'] = $item["id"];
            $user['total_value'] = $item['total_value'];
            $user['total_orders'] = $item['total_orders'];
            $users[] = $user;
        }
        return $users;
    }

    /**
     * Trouve un utilisateur par son adresse e-mail.
     *
     * @param string $email L'adresse e-mail de l'utilisateur à trouver.
     * @return User|null L'objet utilisateur trouvé ou null s'il n'existe pas.
     */
    public function findByEmail(string $email): ?User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE email=:email');
        $parameters = ["email" => $email];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["address"], $result["city"], $result["postal_code"], $result["country"], $result["role"]);
            $user->setId($result["id"]);
            return $user;
        }
        return null;
    }

    /**
     * Crée un nouvel utilisateur dans la base de données.
     *
     * @param User $user L'utilisateur à créer.
     * @return void
     */
    public function create(User $user): int
    {
        $query = $this->db->prepare('INSERT INTO users (id, first_name, last_name, email, password, address, city, postal_code, country, role) VALUES (NULL, :first_name, :last_name, :email, :password, :address, :city, :postal_code, :country, :role)');
        $parameters = [
            "first_name" => $user->getFirstName(),
            "last_name" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "address" => $user->getAddress(),
            "city" => $user->getCity(),
            "postal_code" => $user->getPostalCode(),
            "country" => $user->getCountry(),
            "role" => $user->getRole(),
        ];
        $query->execute($parameters);
        return $this->db->lastInsertId();
    }

    /**
     * Met à jour les informations d'un utilisateur dans la base de données.
     *
     * @param User $user L'utilisateur à mettre à jour.
     * @return void
     */
    public function update(User $user): void
    {
        $query = $this->db->prepare('UPDATE users 
        SET first_name = :first_name, 
            last_name = :last_name, 
            email = :email, 
            password = :password, 
            address = :address, 
            city = :city, 
            postal_code = :postal_code, 
            country = :country, 
            role = :role 
        WHERE id = :id');

        $parameters = [
            "id" => $user->getId(),
            "first_name" => $user->getFirstName(),
            "last_name" => $user->getLastName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword(),
            "address" => $user->getAddress(),
            "city" => $user->getCity(),
            "postal_code" => $user->getPostalCode(),
            "country" => $user->getCountry(),
            "role" => $user->getRole(),
        ];
        $query->execute($parameters);
    }

    /**
     * Supprime un utilisateur par son id
     *
     * @param int $id L'id de l'utilisateur à supprimer.
     * @return bool Retourne true si la suppression a réussi, sinon false.
     */
    public function delete(int $id): bool
    {
        try {
            // Begin a transaction
            $this->db->beginTransaction();

            // Fetch all orders associated with the user
            $fetchOrdersQuery = $this->db->prepare('SELECT id FROM orders WHERE user_id = :id');
            $fetchOrdersQuery->execute(['id' => $id]);
            $orders = $fetchOrdersQuery->fetchAll(PDO::FETCH_COLUMN);

            if ($orders) {
                // Delete articles associated with these orders
                $deleteOrderArticlesQuery = $this->db->prepare('DELETE FROM orders_articles WHERE order_id IN (' . implode(',', array_fill(0, count($orders), '?')) . ')');
                $deleteOrderArticlesQuery->execute($orders);

                // Delete orders associated with the user
                $deleteOrdersQuery = $this->db->prepare('DELETE FROM orders WHERE user_id = :id');
                $deleteOrdersQuery->execute(['id' => $id]);
            }

            // Delete comments associated with the user
            $deleteCommentsQuery = $this->db->prepare('DELETE FROM comments WHERE user_id = :id');
            $deleteCommentsQuery->execute(['id' => $id]);

            // Delete the user
            $deleteUserQuery = $this->db->prepare('DELETE FROM users WHERE id = :id');
            $parameters = ["id" => $id];
            $deleteUserResult = $deleteUserQuery->execute($parameters);

            // Commit the transaction
            $this->db->commit();

            return $deleteUserResult;
        } catch (PDOException $e) {
            // Rollback the transaction if something went wrong
            $this->db->rollBack();
            throw $e;
        }
    }
}
