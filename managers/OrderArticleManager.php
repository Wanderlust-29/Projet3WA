<?php

class OrderArticleManager extends AbstractManager
{
    /**
     * Récupère toutes les commandes des articles.
     *
     * @return array Liste des commandes des articles.
     */
    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM orders_articles');

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $ordersArticles =[];

        foreach ($result as $item){
            $om = new OrderManager();
            $order = $om->findOne($item["order_id"]);
    
            $am = new ArticleManager();
            $article = $am->findOne($item["article_id"]);
    
            $orderArticle = new OrderArticle($order, $article);
            $ordersArticles[] = $orderArticle;
        }
        return $ordersArticles;
    }

    /**
     * Récupère les articles associés à une commande donnée.
     *
     * @param mixed $orderId L'identifiant de la commande.
     * @return array Liste des articles associés à la commande.
     */
    public function findByOrderId($orderId) : array
    {
        $query = $this->db->prepare('SELECT * FROM orders_articles WHERE order_id = :order_id');
        $parameters = [
            "order_id" => $orderId
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $ordersArticles =[];

        foreach ($result as $item){
            $om = new OrderManager();
            $order = $om->findOne($item["order_id"]);
    
            $am = new ArticleManager();
            $article = $am->findOne($item["article_id"]);
    
            $orderArticle = new OrderArticle($order, $article);
            $ordersArticles[] = $orderArticle;
        }
        return $ordersArticles;
    }
}
