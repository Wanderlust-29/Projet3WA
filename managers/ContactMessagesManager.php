<?php

class ContactMessagesManager extends AbstractManager
{

    /**
     * Crée un nouveau commentaire dans la base de données.
     *
     * @param Comment $comment Le commentaire à créer.
     * @return void
     */
    public function create(ContactMessages $contactMessage): void
    {
        $query = $this->db->prepare('INSERT INTO contact_messages (first_name, last_name, email, message) VALUES (:first_name, :last_name, :email, :message)');
        $parameters = [
            "first_name" => $contactMessage->getFirstName(),
            "last_name" => $contactMessage->getLastName(),
            "email" => $contactMessage->getEmail(),
            "message" => $contactMessage->getMessage(),
        ];

        $query->execute($parameters);
        $contactMessage->setId($this->db->lastInsertId());
    }

    /**
     * Récupère tous les messages.
     *
     * 
     * @return ContactMessages Un tableau contenant les messages.
     */
    public function findAll(): array
    {
        $query = $this->db->prepare('SELECT * FROM contact_messages');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $messages = [];
    
        foreach ($result as $item) {
            $message = new ContactMessages($item["first_name"], $item["last_name"], $item["email"], $item["message"]);
            $message->setId($item["id"]);
            $messages[] = $message;
        }
        return $messages;
    }

    /**
     * Supprime un commentaire dans la base de données.
     *
     * @param ContactMessages $ContactMessages Le commentaire à supprimer.
     * @return bool
     */
    public function delete(int $id) : bool
    {
        $query = $this->db->prepare('DELETE FROM contact_messages WHERE id=:id');
        $parameters = [
            "id" => $id
        ];
        $result = $query->execute($parameters);
        return $result;
    }
}
