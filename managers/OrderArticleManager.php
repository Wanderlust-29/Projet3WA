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

    /**
     * Insère les articles associés à une commande donnée dans la table orders_articles.
     *
     * @param int $orderId L'identifiant de la commande.
     * @return void
     */
    public function insertArticles(int $orderId) : void {
        $cart = $_SESSION["cart"];
        foreach ($cart as $articleData) {
            $articleId = $articleData['id'];
    
            $query = $this->db->prepare('INSERT INTO orders_articles (order_id, article_id) 
                VALUES (:order_id, :article_id)');
            $query->execute([
                "order_id" => $orderId,
                "article_id" => $articleId
            ]);
            // Mettre à jour le stock de l'article
            $this->decrementArticleStock($articleId);
        }
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
    

}
