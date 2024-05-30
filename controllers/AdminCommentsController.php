<?php
class AdminCommentsController extends AbstractController
{
    // all comments
    public function comments()
    {
        $cm = new CommentManager();
        $comments = $cm->findAll();

        $this->render("admin/admin-comments.html.twig", [
            'title' => 'Tous les commentaires',
            'comments' => $comments,
        ]);
    }

    // all pending comments
    public function pendingComments()
    {
        $cm = new CommentManager();
        $comments = $cm->findAllpending();

        $this->render("admin/admin-comments.html.twig", [
            'title' => 'Tous les commentaires en attente',
            'comments' => $comments,
        ]);
    }


    // approve comment
    public function approveComment(){
        $type = 'success';
        $text = '';
        if(isset($_POST) && isset($_POST['id'])){
            $id = (int) $_POST['id'];
            $cm = new CommentManager();
            $update = $cm->updateStatus($id, "approved");
            if(!$update){
                $type = 'error';
                $text = "Un problème est survenu lors de la mise à jour 😞";
            }else{
                $text = "La mise à jour a bien été effectuée 😃";
            }
        }else{
            $type = 'error';
            $text = "Une erreur est survenue 🙄";
        }

        $this->notify($text,$type);
        $this->redirect("/admin/comments/pending");
    }

    // delete comment
    public function deleteComment(){
        $type = 'success';
        $text = '';
        if(isset($_POST) && isset($_POST['id'])){
            $id = (int) $_POST['id'];
            $cm = new CommentManager();
            $delete = $cm->delete($id);
            if(!$delete){
                $type = 'error';
                $text = "Un problème est survenu lors de la suppression 😞";
            }else{
                $text = "La suppression a bien été effectuée 😃";
            }
        }else{
            $type = 'error';
            $text = "Une erreur est survenue 🙄";
        }

        $this->notify($text,$type);
        $this->redirect("/admin/comments/pending");
    }

}
