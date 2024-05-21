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
            $order = new Order($id, $result["created_at"],  $result["status"], $result["total_price"]);
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
      
            $order = new Order($item["user_id"], $item["created_at"], $item["status"], $item["total_price"]);
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
    public function allOrdersByUserId(int $userId) : array
    {
        $query = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $parameters = ["user_id" => $userId];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $orders =[];

        foreach ($result as $item){
            $order = new Order($userId, $item["created_at"], $item["status"], $item["total_price"],);
            $order->setId($item["id"]);
            $orders[]= $order;
        }
        return $orders;
    }
    
    /**
     * Crée une nouvelle commande en utilisant la date actuelle.
     *
     * @param Order $order L'objet Order représentant la commande à créer.
     * @return void
     */
    public function createOrder(Order $order) : void
    {
        $query = $this->db->prepare('INSERT INTO orders (user_id, created_at, status, total_price) 
        VALUES (:user_id, :created_at, :status, :total_price)');

        $parameters = [
            "user_id" => $order->getUserId(), // Récupérer l'ID de l'utilisateur
            "created_at" => $order->getCreatedAt(),
            "status" => $order->getStatus(), // Récupérer le statut de la commande
            "total_price" => $order->getTotalPrice() // Récupérer le prix total de la commande
        ];
        
        $query->execute($parameters);
        $orderId = $this->db->lastInsertId();

        $query = $this->db->prepare('INSERT INTO ordersArticles (order_id, article_id) 
        VALUES (:order_id, :article_id)');

        $parameters = [
            "order_id" => $orderId,
            "article_id" => $order->getCreatedAt(),
        ];

        // $ordersArticlesManager = new OrderArticleManager($this->db);
        // $ordersArticlesManager->insertArticles($orderId);
    }

    /**
     * Retrieves all articles for a specific order.
     *
     * @param int $orderId Order ID.
     * @return array List of articles for the order.
     */
    public function orderArticle(int $orderId) : array {
        $query = $this->db->prepare(
            'SELECT a.image_id, a.name, a.price 
             FROM orders_articles AS oa 
             LEFT JOIN articles AS a ON oa.article_id = a.id 
             WHERE oa.order_id = :order_id'
        );
        $query->execute(['order_id' => $orderId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function oldOrderArticle(int $orderId) : array {
    //     $query = $this->db->prepare(
    //         'SELECT a.*
    //          FROM orders_articles AS oa 
    //          LEFT JOIN articles AS a ON oa.article_id = a.id 
    //          WHERE oa.order_id = :order_id'
    //     );
    //     $query->execute(['order_id' => $orderId]);
    //     $result = $query->fetchAll(PDO::FETCH_ASSOC);
    //     $article =[];
    //     foreach ($result as $item){

    //         $mm = new MediaManager();
    //         $media = $mm->findOne($item["image_id"]);
    
    //         $cm = new CategoryManager();
    //         $category = $cm->findOne($item["category_id"]);

    //         $article = new Article($item["name"], $item["price"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"]);
    //         $$article->setId($item["id"]);
    //         $article[]= $article;
    //     }
    //     return $articles;
    // }
}
