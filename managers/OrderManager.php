<?php

class OrderManager extends AbstractManager
{   
    /**
     * Récupère une commande par son identifiant.
     *
     * @param int $id L'identifiant de la commande à récupérer.
     * @return Order|null L'objet commande trouvé ou null s'il n'existe pas.
     */
    public function findOne(int $id) : ?Order
    {
        $query = $this->db->prepare('SELECT * FROM orders WHERE id=:id');
        $parameters = ["id" => $id];
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

    /**
     * Récupère toutes les commandes.
     *
     * @return array Liste des commandes.
     */
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

        /**
     * Récupère toutes les commandes par ordre décroissant.
     *
     * @return array Liste des commandes.
     */
    public function findAllDecreasing() : array
    {
        $query = $this->db->prepare('SELECT * FROM `orders` ORDER BY `orders`.`created_at` DESC');
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

    /**
     * Récupère toutes les commandes associées à un utilisateur.
     *
     * @param mixed $userId L'identifiant de l'utilisateur.
     * @return array Liste des commandes de l'utilisateur.
     */
    public function findByUserId($userId) : array
    {
        $query = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $parameters = ["user_id" => $userId];
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
