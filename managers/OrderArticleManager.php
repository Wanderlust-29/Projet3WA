<?php

class OrderArticleManager extends AbstractManager
{   

    public function findOne(int $id) : ?OrderArticle
    {
        $query = $this->db->prepare('SELECT * FROM orders_articles
                                    WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        $om = new OrderManager();
        $order = $om->findOne($result["order_id"]);
        // $newOrder = new Order()

        $am = new ArticleManager();
        $article = $am->findOne($result["article_id"]);

        $orderArticle = new OrderArticle($order, $article);
        $orderArticle->setId($result["id"]);
        return $orderArticle;
    }

    public function findAll() : array
    {
        $query = $this->db->prepare('SELECT * FROM orders_articles');

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $ordersArticles =[];

        foreach ($result as $item){
            $om = new OrderManager();
            $order = $om->findOne($item["order_id"]);
            // $newOrder = new Order()
    
            $am = new ArticleManager();
            $article = $am->findOne($item["article_id"]);
    
            $orderArticle = new OrderArticle($order, $article);
            $orderArticle->setId($item["id"]);
            $ordersArticles[] = $orderArticle;
        }
        return $ordersArticles;
    }
}