<?php

class UserManager extends AbstractManager
{
    /**
     * Finds a user by their identifier.
     *
     * @param int $id The user's identifier to find.
     * @return User|null The found user object or null if it doesn't exist.
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
     * Fetches all users from the database, including total orders and total value.
     *
     * @return array List of users with additional aggregated data.
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
     * Finds a user by their email address.
     *
     * @param string $email The email address of the user to find.
     * @return User|null The found user object or null if it doesn't exist.
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
     * Creates a new user in the database.
     *
     * @param User $user The user to create.
     * @return int|null The ID of the newly created user or null if there was an error.
     */
    public function create(User $user): ?int
    {
        $query = $this->db->prepare('INSERT INTO users (first_name, last_name, email, password, address, city, postal_code, country, role) VALUES (:first_name, :last_name, :email, :password, :address, :city, :postal_code, :country, :role)');
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
        $success = $query->execute($parameters);
        return $success ? (int)$this->db->lastInsertId() : null; // Retourne l'ID de l'utilisateur ou null en cas d'erreur
    }

    /**
     * Updates a user's information in the database.
     *
     * @param User $user The user to update.
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
     * Deletes a user from the database, including related orders and comments.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True if deletion was successful, false otherwise.
     * @throws Exception If there was an error during deletion.
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
