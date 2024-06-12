<?php
class AdminMessagesController extends AbstractController
{
    /**
     * Renders the page with all messages.
     */
    public function messages(): void
    {
        $cmm = new ContactMessagesManager();
        $messages = $cmm->findAll();

        $this->render("admin/admin-messages.html.twig", [
            'title' => 'Tous les messages',
            'messages' => $messages,
        ]);
    }

    /**
     * Deletes a message.
     */
    public function deleteMessage(): void
    {
        $type = 'success';
        $text = '';

        if (isset($_POST) && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $cmm = new ContactMessagesManager();
            $delete = $cmm->delete($id);
            if (!$delete) {
                $type = 'error';
                $text = "Un problème est survenu lors de la suppression 😞";
            } else {
                $text = "La suppression a bien été effectuée 😃";
            }
        } else {
            $type = 'error';
            $text = "Une erreur est survenue 🙄";
        }

        $this->notify($text, $type);
        $this->redirect("/admin/messages/");
    }
}
