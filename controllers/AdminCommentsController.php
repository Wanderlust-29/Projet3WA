<?php

class AdminCommentsController extends AbstractController
{
    /**
     * Renders the page displaying all comments.
     */
    public function comments(): void
    {
        $cm = new CommentManager();
        $comments = $cm->findAll();

        $this->render("admin/admin-comments.html.twig", [
            'title' => 'Tous les commentaires',
            'comments' => $comments,
        ]);
    }

    /**
     * Renders the page displaying all pending comments.
     */
    public function pendingComments(): void
    {
        $cm = new CommentManager();
        $comments = $cm->findAllpending();

        $this->render("admin/admin-comments.html.twig", [
            'title' => 'Tous les commentaires en attente',
            'comments' => $comments,
        ]);
    }

    /**
     * Approves a comment based on the provided ID.
     * Redirects to the pending comments page after approval.
     */
    public function approveComment(): void
    {
        $type = 'success';
        $text = '';
        if (isset($_POST) && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $cm = new CommentManager();
            $update = $cm->updateStatus($id, "approved");
            if (!$update) {
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            } else {
                $text = "La mise à jour a bien été effectuée 😃";
            }
        } else {
            $type = 'error';
            $text = "Une erreur est survenue 🙄";
        }

        $this->notify($text, $type);
        $this->redirect("/admin/comments/pending");
    }

    /**
     * Deletes a comment based on the provided ID.
     * Redirects to the pending comments page after deletion.
     */
    public function deleteComment(): void
    {
        $type = 'success';
        $text = '';
        if (isset($_POST) && isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $cm = new CommentManager();
            $delete = $cm->delete($id);
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
        $this->redirect("/admin/comments/pending");
    }
}
