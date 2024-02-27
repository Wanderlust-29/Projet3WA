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


        $user = new Order($result["user_id"], $result["created_at"]);
        $user->setId($result["id"]);
        return $user;
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM orders');

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $orders =[];

        foreach ($result as $item){
            $order = new Order($item["user_id"], $item["created_at"]);
            $order->setId($item["id"]);
            $orders[]= $order;
        }
        return $orders;
    }
}