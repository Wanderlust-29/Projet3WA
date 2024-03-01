<?php

class UserManager extends AbstractManager
{   

    public function findOne(int $id) : ? User
    {
        $query = $this->db->prepare('SELECT * FROM users
                                    WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $user = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["address"], $result["city"], $result["postal_code"], $result["country"], $result["role"]);
            $user->setId($result["id"]);
            return $user;
        }
        return null;
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM users');

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $users =[];

        foreach ($result as $item){
            $user = new User($item["first_name"], $item["last_name"], $item["email"], $item["password"], $item["address"], $item["city"], $item["postal_code"], $item["country"], $item["role"]);
            $user->setId($item["id"]);
            $users[]= $user;
        }
        return $users;
    }

    public function findByEmail(string $email) : ? User
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE email=:email');

        $parameters = [
            "email" => $email
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $user = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["address"], $result["city"], $result["postal_code"], $result["country"], $result["role"]);
            $user->setId($result["id"]);

            return $user;
        }
        return null;
    }
    public function create(User $user) : void
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

        $user->setId($this->db->lastInsertId());

    }
}