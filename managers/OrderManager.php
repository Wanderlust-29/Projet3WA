<?php

class OrderManager extends AbstractManager
{
    /**
     * Récupère une commande par son identifiant.
     *
     * @param int $id L'identifiant de la commande à récupérer.
     * @return Order|null L'objet commande trouvé ou null s'il n'existe pas.
     */
    public function findOne(int $id): ?Order
    {
        $query = $this->db->prepare('SELECT * FROM orders WHERE id=:id');
        $parameters = ["id" => $id];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
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
    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM orders');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];

        foreach ($result as $item) {

            $order = new Order($item["user_id"], $item["created_at"], $item["status"], $item["total_price"]);
            $order->setId($item["id"]);
            $orders[] = $order;
        }
        return $orders;
    }

    /**
     * Récupère toutes les commandes associées à un utilisateur.
     *
     * @param mixed $userId L'identifiant de l'utilisateur.
     * @return array Liste des commandes de l'utilisateur.
     */
    public function allOrdersByUserId(int $userId): array
    {
        $query = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $parameters = ["user_id" => $userId];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];

        foreach ($result as $item) {
            $order = new Order($userId, $item["created_at"], $item["status"], $item["total_price"],);
            $order->setId($item["id"]);
            $orders[] = $order;
        }
        return $orders;
    }

    /**
     * Crée une nouvelle commande en utilisant la date actuelle.
     *
     * @param Order $order L'objet Order représentant la commande à créer.
     * @return void
     */
    public function createOrder(Order $order): void
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
    public function insertArticles(int $orderId): void
    {
        $cart = isset($_SESSION["cart"]["articles"]) ? $_SESSION["cart"]["articles"] : null;
        $shipping = isset($_SESSION['cart']['shipping_costs']) ? $_SESSION['cart']['shipping_costs'] : null;

        foreach ($cart as $articleData) {
            $type = "article";
            $articleId = $articleData['id'];
            $price = $articleData['price'];
            $quantity = $articleData['quantity'];

            $query = $this->db->prepare('INSERT INTO orders_articles (order_id, article_id, item_type, item_price, item_quantity) 
                VALUES (:order_id, :article_id, :item_type, :item_price, :item_quantity)');
            $query->execute([
                "order_id" => $orderId,
                "article_id" => $articleId,
                "item_type" => $type,
                "item_price" => $price,
                "item_quantity" => $quantity
            ]);

            // Mettre à jour le stock de l'article
            $this->decrementArticleStock($articleId);
        }
        if (!is_null($shipping)) {
            $type = "shipping";
            $articleId = $shipping['id'];
            $price = $shipping['price'];
            $quantity = 1;

            $query = $this->db->prepare('INSERT INTO orders_articles (order_id, article_id, item_type, item_price, item_quantity) 
                VALUES (:order_id, :article_id, :item_type, :item_price, :item_quantity)');
            $query->execute([
                "order_id" => $orderId,
                "article_id" => $articleId,
                "item_type" => $type,
                "item_price" => $price,
                "item_quantity" => $quantity
            ]);
        }
        unset($_SESSION["cart"]);
    }

    /**
     * Méthode pour décrémenter le stock d'un article.
     *
     * @param int $articleId L'identifiant de l'article.
     * @return void
     */
    private function decrementArticleStock(int $articleId): void
    {
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
     * Méthode pour récuperer les articles d'une commande.
     *
     * @param int $orderId Order ID.
     * @return array liste des articles.
     */
    public function orderArticle(int $orderId): array
    {
        $query = $this->db->prepare(
            'SELECT a.image_id, a.name, a.price 
             FROM orders_articles AS oa 
             LEFT JOIN articles AS a ON oa.article_id = a.id 
             WHERE oa.order_id = :order_id'
        );
        $query->execute(['order_id' => $orderId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Méthode pour ajouter la quantité d'un article dans order_article.
     *
     * @param int $quantity.
     * @return void
     */
    public function updateQuantity(int $quantity, int $orderId, int $articleId): void
    {
        $query = $this->db->prepare(
            'UPDATE order_article SET item_quantity = :quantity WHERE order_id = :order_id AND article_id = :article_id'
        );

        $parameters = [
            "quantity" => $quantity,
            "order_id" => $orderId,
            "article_id" => $articleId,
        ];

        $query->execute($parameters);
    }

    /**
     * Méthode pour ajouter le prix d'un item dans orders_articles.
     *
     * @param int $item_price L'identifiant de l'article.
     * @return void
     */
    public function updatePrice(int $itemPrice, $orderId, int $articleId): void
    {
        $query = $this->db->prepare(
            'UPDATE orders_articles oa
            JOIN articles a ON oa.article_id = a.id
            SET oa.item_price = a.price
            WHERE order_id = :order_id AND article_id = article_id'
        );

        $parameters = [
            "item_price" => $itemPrice,
            "order_id" => $orderId,
            "article_id" => $articleId
        ];

        $query->execute($parameters);
    }
}
