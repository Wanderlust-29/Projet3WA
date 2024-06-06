<?php

class OrderManager extends AbstractManager
{

    public array $statusArray = [
        [
            'code' => 'success',
            'text' => 'Commande payée'
        ], [
            'code' => 'send',
            'text' => 'Commande envoyée'
        ], [
            'code' => 'delivered',
            'text' => 'Commande receptionnée'
        ]
    ];

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
            $sm = new ShippingManager();
            $shipping = $sm->findOne($result["shipping_id"]);

            $order = new Order($result["user_id"], $result["created_at"],  $result["status"], $shipping, $result["total_price"]);
            $order->setId($id);
            $user = $this->orderUser($result["user_id"]);
            $order->setUser($user);
            $articles = $this->orderArticle($id);
            $order->setArticles($articles);
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

            $sm = new ShippingManager();
            $shipping = $sm->findOne($item["shipping_id"]);

            $order = new Order($item["user_id"], $item["created_at"], $item["status"], $shipping, $item["total_price"]);
            $order->setId($item["id"]);

            $user = $this->orderUser($item["id"]);
            $order->setUser($user);
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

            $sm = new ShippingManager();
            $shipping = $sm->findOne($item["shipping_id"]);

            $order = new Order($userId, $item["created_at"], $item["status"], $shipping, $item["total_price"],);
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
        $query = $this->db->prepare('INSERT INTO orders (user_id, created_at, status, shipping_id, total_price) 
        VALUES (:user_id, :created_at, :status, :shipping_id, :total_price)');

        $parameters = [
            "user_id" => $order->getUserId(), // Récupérer l'ID de l'utilisateur
            "created_at" => $order->getCreatedAt(),
            "status" => $order->getStatus(), // Récupérer le statut de la commande
            "shipping_id" => $order->getShippingId()->getId(), // Récupérer le statut de la commande
            "total_price" => $order->getTotalPrice() // Récupérer le prix total de la commande
        ];

        $query->execute($parameters);
        $orderId = $this->db->lastInsertId();
        $this->insertArticles($orderId);
    }

        /**
     * Récupère le frais de port en fonction de l'ID de commande.
     *
     * @param int $orderId L'ID de la commande.
     * @return Shipping|null L'objet Shipping correspondant ou null s'il n'existe pas.
     */
    public function findShippingByOrderId(int $orderId): ?Shipping
    {
        $query = $this->db->prepare('SELECT shipping_id FROM orders WHERE id = :orderId');
        $parameters = [
            "orderId" => $orderId
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['shipping_id'])) {
            // Si shipping_id existe dans le résultat, utilisez ShippingManager pour récupérer le frais de port correspondant
            $shippingId = $result['shipping_id'];
            $shippingManager = new ShippingManager();
            return $shippingManager->findOne($shippingId);
        }

        return null;
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

        foreach ($cart as $articleData) {
            $articleId = $articleData['id'];
            $price = $articleData['price'];
            $quantity = $articleData['quantity'];

            $query = $this->db->prepare('INSERT INTO orders_articles (order_id, article_id, item_price, item_quantity) 
                VALUES (:order_id, :article_id, :item_price, :item_quantity)');
            $query->execute([
                "order_id" => $orderId,
                "article_id" => $articleId,
                "item_price" => $price,
                "item_quantity" => $quantity
            ]);

            // Mettre à jour le stock de l'article
            $this->decrementArticleStock($articleId);
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
     * Retrieves all articles for a specific order.
     *
     * @param int $orderId Order ID.
     * @return array List of articles for the order.
     */
    public function orderArticle(int $orderId): array
    {
        $query = $this->db->prepare(
            'SELECT a.*, oa.item_price as formerPrice, oa.item_quantity as quantity
             FROM orders_articles AS oa
             LEFT JOIN articles AS a ON oa.article_id = a.id 
             WHERE oa.order_id = :order_id'
        );
        $query->execute(['order_id' => $orderId]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $articles = [];
        foreach ($result as $item) {

            $mm = new MediaManager();
            $media = $mm->findOne($item["image_id"]);

            $cm = new CategoryManager();
            $category = $cm->findOne($item["category_id"]);

            $article = new Article($item["name"], $item["formerPrice"], $item["stock"], $category, $media, $item["description"], $item["ingredients"], $item["age"], $item["short_description"], $item["slug"]);
            $article->setId($item["id"]);
            $article = $article->toArray();
            $article['quantity'] = $item['quantity'];
            $articles[] = $article;
        }
        return $articles;
    }

    /**
     * Récupère les informations de l'utilisateur
     *
     * @param int $orderId Order ID.
     * @return array Informations utilisateur.
     */
    public function orderUser(int $userId): array
    {
        $user = new UserManager();
        $u = $user->findOne($userId);
        if ($u) {
            return $u->toArray();
        }
        return [];
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
    /**
     * Retrieves all articles for a specific order.
     *
     * @param int $orderId Order ID.
     * @param string $status Nouveau status de la commande
     * @return bool update effectuée
     */
    public function updateStatus(int $orderId, string $status): bool
    {
        $query = $this->db->prepare(
            'UPDATE orders SET status = :status WHERE id=:id'
        );
        $result = $query->execute(['status' => $status, 'id' => $orderId]);
        return $result;
    }

    /**
     * Retourne le chiffre d'affaires du mois en cours.
     *
     * @return float total chiffre d'affires
     */
    function getMonthlyEarning(): float
    {
        $query = $this->db->prepare('SELECT SUM(total_price) AS total FROM orders WHERE MONTH(created_at)=MONTH(curdate())');
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'] !== null ? (float)$result['total'] : 0.0;
    }

    /**
     * Retourne le chiffre d'affaires du mois en cours.
     *
     * @return float total chiffre d'affires
     */
    function getYearlyEarning(): float
    {
        $query = $this->db->prepare('SELECT SUM(total_price) AS total FROM orders WHERE YEAR(created_at) = YEAR(curdate())');
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'] !== null ? (float)$result['total'] : 0.0;
    }

    /**
     * Retourne le nombre de commandes en cours
     *
     * @return int total commandes en cours
     */
    function getPendingOrdersTotal(): int
    {
        $query = $this->db->prepare('SELECT SUM(id) AS total FROM orders WHERE status = "success" GROUP BY id');
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['total'];
        } else {
            return 0;
        }
    }
}
