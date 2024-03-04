<?php

class OrderManager extends AbstractManager
{   

    public function findOne(int $id) : ?Order
    {
        $query = $this->db->prepare('SELECT * FROM orders
                                    WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result)
        {
            $um = new UserManager;
            $user = $um->findOne($result["user_id"]);

            $order = new Order($user, $result["created_at"]);
            $order->setId($result["id"]);
            return $order;
        }
        return null;
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM orders');

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $orders =[];

        foreach ($result as $item){

            $um = new UserManager;
            $user = $um->findOne($item["user_id"]);

            $order = new Order($user, $item["created_at"]);
            $order->setId($item["id"]);
            $orders[]= $order;
        }
        return $orders;
    }
    public function findByUserId($userId) : array
    {
        $query = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $parameters = [
            "user_id" => $userId
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $orders =[];

        foreach ($result as $item){

            $um = new UserManager;
            $user = $um->findOne($item["user_id"]);

            $order = new Order($user, $item["created_at"]);
            $order->setId($item["id"]);
            $orders[]= $order;
        }
        return $orders;
    }
}