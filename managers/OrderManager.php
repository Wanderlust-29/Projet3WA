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
        $this->insertArticles($orderId);
    }

    /**
     * Insère les articles associés à une commande donnée dans la table orders_articles.
     *
     * @param int $orderId L'identifiant de la commande.
     * @return void
     */
    public function insertArticles(int $orderId) : void {
        $cart = $_SESSION["cart"];
        foreach ($cart as $key => $articleData) {
            if($key == "shipping_costs"){
                $type = "shipping";
                switch ($articleData["name"]) {
                    case '2-3 jours ouvrés Udp':
                        $articleId = 1;
                        break;
                    case 'Chronopost 4-5 jours ouvrés':
                        $articleId = 2;
                        break;
                    case 'Venir chercher sur place':
                        $articleId = 3;
                        break;
                    default:
                        $articleId = 1;
                        break;
                }
            }else{
                $type = "article";
                $articleId = $articleData['id'];
            }
            
            $query = $this->db->prepare('INSERT INTO orders_articles (order_id, article_id,item_type) 
                VALUES (:order_id, :article_id, :item_type)');
            $query->execute([
                "order_id" => $orderId,
                "article_id" => $articleId,
                "item_type" => $type
            ]);
            // Mettre à jour le stock de l'article
            if($type == 'article'){
                $this->decrementArticleStock($articleId);
            }
        }
        unset($_SESSION["cart"]);
    }

    /**
     * Méthode pour décrémenter le stock d'un article.
     *
     * @param int $articleId L'identifiant de l'article.
     * @return void
     */
    private function decrementArticleStock(int $articleId) : void {
        $am = new ArticleManager($this->db); 
        $article = $am->findOne($articleId); 
    
        if ($article) {
            // Décrémente le stock de 1
            $article->setStock($article->getStock() - 1);
    
            // Met à jour le stock de l'article dans la base de données
            $am->update($article);
        }
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
