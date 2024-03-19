<?php

class Cart
{
    /**
     * @var array $items Tableau contenant les articles dans le panier
     */
    private $items = [];

    /**
     * Ajoute un article au panier
     * 
     * @param Item $item L'article à ajouter
     */
    public function addItem($item)
    {
        $this->items[] = $item;
    }

    /**
     * Récupère les articles dans le panier
     * 
     * @return array Les articles dans le panier
     */
    public function getItems()
    {
        return $this->items;
    }
    
    /**
     * Met à jour les articles dans le panier
     * 
     * @param array $items Les nouveaux articles à mettre dans le panier
     */
    public function setItems($items)
    {
        $this->items = $items;
    }
    /**
     *  Méthode pour transformer les éléments du panier en tableau
     * 
     * @param array $items en array
     */

    public function toArray() {
        $itemsArray = array();
        
        foreach ($this->items as $item) {
            // Transformation de chaque élément du panier en tableau
            $itemArray = $item->toArray();
            array_push($itemsArray, $itemArray);
        }

        return $itemsArray;
    }
}
