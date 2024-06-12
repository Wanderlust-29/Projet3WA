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
     * Fetches an order by its identifier.
     *
     * @param int $id The identifier of the order.
     * @return Order|null The found order object or null if it doesn't exist.
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
     * Fetches an order by its identifier for the user's account.
     *
     * @param int $id The identifier of the order.
     * @param int $user_id The identifier of the user.
     * @return Order|null The found order object or null if it doesn't exist.
     */
    public function findOneForAccount(int $id, int $user_id): ?Order
    {
        $query = $this->db->prepare('SELECT * FROM orders WHERE id=:id AND user_id=:user_id');
        $parameters = ["id" => $id, "user_id" => $user_id];
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
     * Fetches the last order made by a user based on user ID.
     *
     * @param int $id The identifier of the user.
     * @return Order|null The found order object or null if it doesn't exist.
     */
    public function findLastOrder(int $id): ?Order
    {
        $query = $this->db->prepare('SELECT * FROM orders WHERE user_id=:id ORDER BY created_at DESC LIMIT 0,1');
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
     * Fetches all orders.
     *
     * @return array List of order objects.
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
     * Fetches all orders associated with a specific user.
     *
     * @param int $userId The identifier of the user.
     * @return array List of orders associated with the user.
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
     * Creates a new order using the current date.
     *
     * @param Order $order The Order object representing the order to create.
     * @return void
     */
    public function createOrder(Order $order): void
    {
        $query = $this->db->prepare('INSERT INTO orders (user_id, created_at, status, shipping_id, total_price) 
        VALUES (:user_id, :created_at, :status, :shipping_id, :total_price)');

        $parameters = [
            "user_id" => $order->getUserId(),
            "created_at" => $order->getCreatedAt(),
            "status" => $order->getStatus(),
            "shipping_id" => $order->getShippingId()->getId(),
            "total_price" => $order->getTotalPrice()
        ];

        $query->execute($parameters);
        $orderId = $this->db->lastInsertId();
        $this->insertArticles($orderId);
    }

    /**
     * Fetches the shipping details for an order based on its order ID.
     *
     * @param int $orderId The ID of the order.
     * @return Shipping|null The corresponding Shipping object or null if it doesn't exist.
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

            $shippingId = $result['shipping_id'];
            $shippingManager = new ShippingManager();
            return $shippingManager->findOne($shippingId);
        }

        return null;
    }

    /**
     * Inserts the articles associated with a given order into the orders_articles table.
     *
     * @param int $orderId The identifier of the order.
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

            $this->decrementArticleStock($articleId);
        }
        unset($_SESSION["cart"]);
    }

    /**
     * Decreases the stock of an article by 1.
     *
     * @param int $articleId The identifier of the article.
     * @return void
     */
    private function decrementArticleStock(int $articleId): void
    {
        $am = new ArticleManager($this->db);
        $article = $am->findOne($articleId);

        if ($article) {
            // stock -1
            $article->setStock($article->getStock() - 1);

            $am->update($article);
        }
    }

    /**
     * Retrieves all articles associated with a specific order.
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
     * Fetches user information associated with an order.
     *
     * @param int $userId User ID.
     * @return array User information.
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
     * Updates the quantity of an article in the orders_articles table.
     *
     * @param int $quantity The new quantity.
     * @param int $orderId The order ID.
     * @param int $articleId The article ID.
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
     * Updates the price of an item in the orders_articles table.
     *
     * @param int $itemPrice The new price.
     * @param int $orderId The order ID.
     * @param int $articleId The article ID.
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
     * Updates the status of an order.
     *
     * @param int $orderId The order ID.
     * @param string $status The new status of the order.
     * @return bool True if update was successful, false otherwise.
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
     * Retrieves the total earnings for the current month.
     *
     * @return float Total earnings.
     */
    function getMonthlyEarning(): float
    {
        $query = $this->db->prepare('SELECT SUM(total_price) AS total FROM orders WHERE MONTH(created_at)=MONTH(curdate())');
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'] !== null ? (float)$result['total'] : 0.0;
    }

    /**
     * Retrieves the total earnings for the current year.
     *
     * @return float Total earnings.
     */
    function getYearlyEarning(): float
    {
        $query = $this->db->prepare('SELECT SUM(total_price) AS total FROM orders WHERE YEAR(created_at) = YEAR(curdate())');
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['total'] !== null ? (float)$result['total'] : 0.0;
    }

    /**
     * Retrieves the total number of pending orders.
     *
     * @return int Total number of pending orders.
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
