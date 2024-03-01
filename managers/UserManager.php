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
            $user = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["adress"], $result["city"], $result["postal_code"], $result["country"], $result["role"]);
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
            $user = new User($item["first_name"], $item["last_name"], $item["email"], $item["password"], $item["adress"], $item["city"], $item["postal_code"], $item["country"], $item["role"]);
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
            $user = new User($result["first_name"], $result["last_name"], $result["email"], $result["password"], $result["adress"], $result["city"], $result["postal_code"], $result["country"], $result["role"]);
            $user->setId($result["id"]);
            
            return $user;
        }
        return null;
    }
}